<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Http\Requests\RiwayatPembayaranSearchRequest;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RiwayatPembayaranController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(RiwayatPembayaranSearchRequest $request)
    {
        $search = $request->validated();
        $currentDate = now();

        $pelanggan = auth()->user()->pelanggan;
        $years = DB::table('tagihans')->selectRaw('YEAR(`tanggal_tagihan`) as year')->where('pelanggan_id', $pelanggan->id)->groupBy('year')->get();
        $year = isset($search['tahun']) ? $search['tahun'] : $currentDate->year;

        $riwayat = Tagihan::with('subtagihan')->where('pelanggan_id', $pelanggan->id)->whereYear('tanggal_tagihan', $year)->get();

        return view('pelanggan.riwayat-pembayaran', [
            'riwayat' => $riwayat,
            'years' => $years,
            'selectedYear' => $year,
        ]);
    }
}
