<?php

namespace App\Services;

use App\Enums\StatusPengajuan;
use App\Enums\StatusTagihan;
use App\Models\Pelanggan;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TagihanService
{
    public function refreshIsolirStatus(Tagihan $tagihan)
    {
        $client = MikrotikService::getInstance();

        switch ($tagihan->status_tagihan) {
            case StatusTagihan::TERLAMBAT:
                $client->isolir($tagihan->pelanggan->ip_address);
                break;
            default:
                $client->batalIsolir($tagihan->pelanggan->ip_address);
                break;
        }

        return true;
    }

    // It will refresh the status of tagihan, it will override status if the status is BELUM_BAYAR
    public function refreshTagihanStatus(Tagihan $tagihan, Carbon $currentDate, ?StatusTagihan $overideStatus = null)
    {
        $notpay = $tagihan->getUnpayedNominal() > 0;

        if ($notpay) {
            $status = StatusTagihan::BELUM_BAYAR;

            if ($currentDate->day >= $tagihan->pelanggan->tanggal_jatuh_tempo) {
                $status = StatusTagihan::TERLAMBAT;
            }

            if (!is_null($overideStatus)) {
                $status = $overideStatus;
            }

            $tagihan->fill([
                'status_tagihan' => $status,
            ]);

            return $tagihan->save();
        }

        $tagihan->fill([
            'status_tagihan' => StatusTagihan::LUNAS,
        ]);

        return $tagihan->save();
    }

    public function bayar(Tagihan $tagihan, Carbon $currentDate): bool
    {
        $totalNominalTagihan = $tagihan->getNominal();
        // $tagihan->fill([
        //     'status_tagihan' => StatusTagihan::LUNAS,
        // ]);

        $subtagihans = $tagihan->subtagihan()->where('terbayar', false)->get();
        $keterangan = $currentDate->translatedFormat('F');

        if (count($subtagihans) <= 1 && count($tagihan->pembayaran) >= 1) {
            $keterangan = $subtagihans->first()->keterangan;
        }

        $sudahBayar = $tagihan->pembayaran()->where('tanggal_bayar', '!=', null)->get();
        $nominalSudahBayar = $sudahBayar->sum(function ($pendapatan) {
            return $pendapatan->getNominal();
        });

        // INFO : Check if there are pengajuan tagihan
        $pengajuanPembayaran = $tagihan->pembayaran()
            ->with('subtagihan')
            ->where('status_pengajuan', StatusPengajuan::PENDING->name)->first();
        if ($pengajuanPembayaran) {
            $pengajuanPembayaran->fill([
                'tanggal_bayar' => $currentDate,
                'status_pengajuan' => StatusPengajuan::SUKSES,
            ]);

            $totalNominal = $nominalSudahBayar + $pengajuanPembayaran->getNominal();
            if ($totalNominal >= $totalNominalTagihan) {
                $tagihan->fill([
                    'status_tagihan' => StatusTagihan::LUNAS,
                ]);

                $tagihan->save();
            }

            return $pengajuanPembayaran->save();
        }

        $pembayaran = $tagihan->pembayaran()->create([
            'keterangan' => $keterangan,
            'tanggal_bayar' => $currentDate,
        ]);

        foreach ($subtagihans as $subtagihan) {
            $subtagihan->fill(['terbayar' => true]);
            $subtagihan->pembayaran()->attach($pembayaran->id);
            $subtagihan->save();
        }

        $totalNominal = $nominalSudahBayar + $pembayaran->getNominal();
        if ($totalNominal >= $totalNominalTagihan) {
            $tagihan->fill([
                'status_tagihan' => StatusTagihan::LUNAS,
            ]);

            $tagihan->save();
        }

        return $tagihan->save();
    }

    public function ajukanUlang(Pembayaran $pembayaran, Carbon $currentDate)
    {
        $pembayaran->fill([
            'tanggal_pengajuan' => $currentDate,
            'status_pengajuan' => StatusPengajuan::PENDING,
        ]);

        return $pembayaran->save();
    }

    public function ajukan(Tagihan $tagihan, Carbon $currentDate)
    {
        $subtagihans = $tagihan->subtagihan()->where('terbayar', false)->get();
        $keterangan = $currentDate->translatedFormat('F');


        $jumlahPembayaran = Tagihan::where('pelanggan_id', $tagihan->pelanggan_id)->first()->pembayaran->count();
        if ($jumlahPembayaran >= 1) {
            $keterangan = $tagihan->getFirstKeterangan();
        }

        $pembayaran = $tagihan->pembayaran()->create([
            'keterangan' => $keterangan,
            'tanggal_pengajuan' => $currentDate,
            'status_pengajuan' => StatusPengajuan::PENDING,
            'kasir_id' => auth()->user()->kasir->id,
        ]);

        foreach ($subtagihans as $subtagihan) {
            $subtagihan->pembayaran()->attach($pembayaran->id);
        }

        return $tagihan->save();
    }

    public function konfirmasi(Pembayaran $pembayaran, Carbon $currentDate)
    {
        $subtagihans = $pembayaran->subtagihan;

        $pembayaran->fill([
            'tanggal_bayar' => $currentDate,
            'status_pengajuan' => StatusPengajuan::SUKSES,
        ]);

        foreach ($subtagihans as $subtagihan) {
            $subtagihan->fill(['terbayar' => true]);
            $subtagihan->save();
        }

        $this->refreshTagihanStatus($pembayaran->tagihan, now());

        return $pembayaran->save();
    }

    public function tolak(Pembayaran $pembayaran)
    {
        $pembayaran->fill([
            'status_pengajuan' => StatusPengajuan::DITOLAK,
        ]);

        return $pembayaran->save();
    }

    public function batal(Tagihan $tagihan, Carbon $currentDate)
    {
        $pembayarans = $tagihan->pembayaran()->with('subtagihan')->get();

        foreach ($pembayarans as $pembayaran) {
            $subtagihans = $pembayaran->subtagihan;

            foreach ($subtagihans as $subtagihan) {
                $subtagihan->fill(['terbayar' => false]);
                $subtagihan->save();
            }

            $pembayaran->subtagihan()->detach();
            $pembayaran->delete();
        }

        $status = StatusTagihan::BELUM_BAYAR;

        if ($currentDate->day >= $tagihan->pelanggan->tanggal_jatuh_tempo) {
            $status = StatusTagihan::TERLAMBAT;
        }

        $tagihan->fill([
            'status_tagihan' => $status,
        ]);

        return $tagihan->save();
    }

    // Refresh status of each entity inside [`Tagihan`] table
    public function refresh(Carbon $date)
    {
        DB::transaction(function () use ($date) {
            $pelanggansTanpaTagihan = Pelanggan::with('paketLangganan')
                ->with('tagihan')
                ->where('tanggal_tagihan', '<=', $date->day)
                ->whereDoesntHave('tagihan', function ($query) use ($date) {
                    $query->whereYear('tanggal_tagihan', $date->year)
                        ->whereMonth('tanggal_tagihan', $date->month);
                })
                ->get();

            foreach ($pelanggansTanpaTagihan as $pelanggan) {
                $nominal = $pelanggan->paketLangganan->harga;
                $keterangan = $pelanggan->paketLangganan->nama;
                $tagihan = $pelanggan->tagihan()->create([
                    'status_tagihan' => StatusTagihan::BELUM_BAYAR,
                    'tanggal_tagihan' => $date,
                ]);

                // TODO : Use the id of paket langganan instead of `keterangan` in this place
                $tagihan->subtagihan()->create([
                    'nominal' => $nominal,
                    'dapat_dihapus' => false,
                    'keterangan' => $keterangan
                ]);
            }

            // TODO : Refactor
            $pelangganTerlambat = Pelanggan::with(['tagihan' => function ($query) use ($date) {
                $query->where('status_tagihan', StatusTagihan::BELUM_BAYAR)
                    ->whereYear('tanggal_tagihan', $date->year)
                    ->whereMonth('tanggal_tagihan', $date->month)
                    ->orderBy('tanggal_tagihan');
            }])
                ->where('tanggal_jatuh_tempo', '<=', $date->day)->get();

            foreach ($pelangganTerlambat as $pelanggan) {
                foreach ($pelanggan->tagihan as $tagihan) {
                    $tagihan->fill(['status_tagihan' => StatusTagihan::TERLAMBAT])->save();
                }
            }
        });
    }

    public function refreshIsolirAll()
    {
        $date = now();
        $count = [0, 0];

        $tagihan = Tagihan::with('pelanggan')
            ->whereYear('tanggal_tagihan', $date->year)
            ->whereMonth('tanggal_tagihan', $date->month)->get();

        foreach ($tagihan as $data) {
            switch ($data->status_tagihan) {
                case StatusTagihan::TERLAMBAT:
                    $count[0]++;
                    break;
                default:
                    $count[1]++;
                    break;
            }
            $this->refreshIsolirStatus($data);
        }

        return $count;
    }
}
