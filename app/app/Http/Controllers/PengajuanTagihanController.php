<?php

namespace App\Http\Controllers;

use App\Enums\StatusPengajuan;
use App\Enums\StatusTagihan;
use App\Http\Requests\PengajuanTagihanSearchRequest;
use App\Http\Requests\StorePengajuanTagihan;
use App\Models\Pelanggan;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use App\Services\TagihanService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PengajuanTagihanController extends Controller
{
    public function index(PengajuanTagihanSearchRequest $request)
    {
        $data = $request->validated();

        $tagihan = [];
        $pengajuan = [];
        $jumlahPembayaran = 0;
        $pelanggan = null;
        if (isset($data['id'])) {
            $id = $data['id'];
            $currentDate = now();


            $tagihan = Tagihan::with('pembayaran')->with('subtagihan')->whereHas('subtagihan', function ($query) {
                $query->whereDoesntHave('pembayaran');
            })
                ->where('pelanggan_id', $id)
                ->whereYear('tanggal_tagihan', $currentDate->year)
                ->get();

            $jumlahPembayaran = Tagihan::where('pelanggan_id', $id)->first()->pembayaran->count();

            $pengajuan = Pembayaran::with('subtagihan')
                ->whereHas('tagihan', function ($query) use ($id, $currentDate) {
                    $query->where('pelanggan_id', $id)
                        ->whereYear('tanggal_tagihan', $currentDate->year);
                })
                ->where('kasir_id', auth()->user()->kasir->id)
                ->get();

            $pelanggan = Pelanggan::findOrFail($id);
        }

        return view('pengajuan-tagihan.index', [
            'tagihan' => $tagihan,
            'jumlahPembayaran' => $jumlahPembayaran,
            'pengajuan' => $pengajuan,
            'pelanggan' => $pelanggan,
        ]);
    }

    public function reStore(Pembayaran $pembayaran, TagihanService $tagihanService)
    {
        if ($tagihanService->ajukanUlang($pembayaran, now())) {
            return redirect()
                ->back()
                ->with('message', [
                    'status' => 'success',
                    'message' => 'Tagihan berhasil di ajukan!',
                ]);
        }

        return redirect()
            ->back()
            ->with('message', [
                'status' => 'failed',
                'message' => 'Tagihan gagal di ajukan!',
            ]);
    }

    public function store(Tagihan $tagihan, TagihanService $tagihanService)
    {
        if ($tagihanService->ajukan($tagihan, now())) {
            return redirect()
                ->back()
                ->with('message', [
                    'status' => 'success',
                    'message' => 'Tagihan berhasil di ajukan!',
                ]);
        }

        return redirect()
            ->back()
            ->with('message', [
                'status' => 'failed',
                'message' => 'Tagihan gagal di ajukan!',
            ]);
    }
}
