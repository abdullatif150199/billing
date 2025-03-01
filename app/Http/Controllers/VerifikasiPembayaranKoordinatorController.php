<?php

namespace App\Http\Controllers;

use App\Enums\StatusPengajuan;
use App\Models\Kasir;
use App\Models\Pembayaran;
use App\Services\TagihanService;
use Illuminate\Database\Eloquent\Builder;

class VerifikasiPembayaranKoordinatorController extends Controller
{
    public function index()
    {
        $pengaju = Kasir::with('areaAlamat')->whereHas('pembayaran', function (Builder $query) {
            $query->where('status_pengajuan', StatusPengajuan::PENDING->name);
        })->withCount(['pembayaran' => function (Builder $query) {
            $query->where('status_pengajuan', StatusPengajuan::PENDING->name);
        }])->get();

        return view('verifikasi-pembayaran.index', [
            'pengaju' => $pengaju,
        ]);
    }

    public function show(Kasir $kasir)
    {
        $tagihan = Pembayaran::where('status_pengajuan', StatusPengajuan::PENDING->name)
            ->with('subtagihan')
            ->with('tagihan.pelanggan.areaAlamat')
            ->where('kasir_id', $kasir->id)->get();

        return view('verifikasi-pembayaran.show', [
            'tagihan' => $tagihan,
            'kasir' => $kasir,
        ]);
    }

    public function store(Kasir $kasir, Pembayaran $pembayaran, TagihanService $tagihanService)
    {
        if ($tagihanService->konfirmasi($pembayaran, now())) {
            try {
                $tagihanService->refreshIsolirStatus($pembayaran->tagihan);
            } catch (\Exception) {
                return redirect()->back()->with('message', [
                    'status' => 'failed',
                    'message' => 'Gagal men-update status isolir!',
                ]);
            }

            return redirect()
                ->back()
                ->with('message', [
                    'status' => 'sukses',
                    'message' => 'Berhasil konfirmasi pengajuan!',
                ]);
        }

        return redirect()
            ->back()
            ->with('message', [
                'status' => 'failed',
                'message' => 'Gagal konfirmasi pengajuan!',
            ]);
    }

    public function destroy(Kasir $kasir, Pembayaran $pembayaran, TagihanService $tagihanService)
    {
        if ($tagihanService->tolak($pembayaran)) {
            try {
                $tagihanService->refreshIsolirStatus($pembayaran->tagihan);
            } catch (\Exception) {
                return redirect()->back()->with('message', [
                    'status' => 'failed',
                    'message' => 'Gagal men-update status isolir!',
                ]);
            }

            return redirect()
                ->back()
                ->with('message', [
                    'status' => 'sukses',
                    'message' => 'Berhasil menolak pengajuan!',
                ]);
        }

        return redirect()
            ->back()
            ->with('message', [
                'status' => 'failed',
                'message' => 'Gagal menolak pengajuan!',
            ]);
    }
}
