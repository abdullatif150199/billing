<?php

namespace App\Http\Controllers;

use App\Enums\StatusPengajuan;
use App\Enums\StatusTagihan;
use App\Models\SubTagihan;
use App\Http\Requests\StoreSubTagihanRequest;
use App\Http\Requests\UpdateSubTagihanRequest;
use App\Models\Tagihan;
use App\Services\TagihanService;

class SubTagihanController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Tagihan $tagihan, StoreSubTagihanRequest $request, TagihanService $tagihanService)
    {
        $data = $request->validated();

        $nominal = isset($data['negative']) ? -intval($data['nominal']) : intval($data['nominal']);

        $subtagihan = $tagihan->subtagihan()->create([
            'keterangan' => $data['keterangan'],
            'nominal' => $nominal,
        ]);

        $tagihanService->refreshTagihanStatus($tagihan, now(), overideStatus: StatusTagihan::BELUM_BAYAR);

        if ($subtagihan) {
            return redirect()->back()->with('message', [
                'status' => 'success',
                'message' => 'Berhasil tambah sub tagihan!',
            ]);
        }

        return redirect()->back()->with('message', [
            'status' => 'failed',
            'message' => 'Gagal tambah sub tagihan!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tagihan $tagihan, SubTagihan $subTagihan, TagihanService $tagihanService)
    {
        if ($subTagihan->dapat_dihapus) {
            try {
                if ($subTagihan->delete()) {
                    $tagihanService->refreshTagihanStatus($tagihan, now(), overideStatus: StatusTagihan::BELUM_BAYAR);

                    return redirect()->back()->with('message', [
                        'status' => 'success',
                        'message' => 'Berhasil menghapus sub tagihan!',
                    ]);
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('message', [
                    'status' => 'failed',
                    'message' => 'Tidak bisa menghapus sub tagihan yang sudah dibayar',
                ]);
            }
        }


        return redirect()->back();
    }
}
