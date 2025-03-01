<?php

namespace App\Http\Controllers;

use App\Http\Requests\KeuanganSearchRequest;
use App\Models\Pembayaran;
use App\Models\Pengeluaran;
use App\Models\Tagihan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class KeuanganController extends Controller
{
    public function __invoke(KeuanganSearchRequest $request)
    {
        $search = $request->validated();
        $currentDate = now();

        $months = array_map(fn ($month) => ['date' => Carbon::create(null, $month), 'selected' => false], range(1, 12));
        $month = isset($search['bulan']) ? $search['bulan'] : $currentDate->month;
        $months[$month - 1]['selected'] = true;

        $years = DB::table('tagihans')->selectRaw('YEAR(`tanggal_tagihan`) as year')->groupBy('year')->get();
        $year = isset($search['tahun']) ? $search['tahun'] : $currentDate->year;

        $pengeluaran = Pengeluaran::whereMonth('tanggal_pengeluaran', $month)
            ->whereYear('tanggal_pengeluaran', $year);

        $pendapatan = Pembayaran::whereMonth('tanggal_bayar', $month)->with('subtagihan')
            ->whereYear('tanggal_bayar', $year)->get();


        $pendapatan = $pendapatan->sum(function ($pendapatan) {
            return $pendapatan->getNominal();
        });
        $pengeluaran = $pengeluaran->get();
        $pengeluaranSum = $pengeluaran->sum('total');
        return view('keuangan.index', [
            'months' => $months,
            'selectedYear' => $year,
            'years' => $years,
            'pendapatan' => $pendapatan,
            'pengeluaran' => $pengeluaran,
            'pengeluaranSum' => $pengeluaranSum,
        ]);
    }
}
