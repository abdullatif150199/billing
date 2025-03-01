<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\DataMaster;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if (auth()->user()->hasRole('admin')) {
            return view('dashboard.index');
        }

        if (auth()->user()->hasRole('pelanggan')) {
            $paket = auth()->user()->pelanggan->tagihan()->orderBy('tanggal_tagihan', 'desc')->first();
            $pengumuman = DataMaster::where('nama', 'pengumuman')->first();
            $status = DataMaster::where('nama', 'status_server')->first();

            return view('dashboard.index', [
                'currentPaket' => $paket,
                'pengumuman' => $pengumuman->data == "" ? "Tidak ada pengumuman" : $pengumuman->data,
                'status' => $status->data,
            ]);
        }

        if (auth()->user()->hasRole('koordinator')) {
            $validator = Validator::make($request->input(), ['bulan' => 'numeric', 'tahun' => 'numeric']);
            $search = $validator->validated();
            $currentDate = now();

            $months = array_map(fn ($month) => ['date' => Carbon::create(null, $month), 'selected' => false], range(1, 12));
            $month = isset($search['bulan']) ? $search['bulan'] : $currentDate->month;
            $months[$month - 1]['selected'] = true;

            $years = DB::table('pembayarans')->selectRaw('YEAR(`tanggal_pengajuan`) as year')
                ->where('kasir_id', auth()->user()->kasir->id)
                ->groupBy('year')
                ->get();
            $year = isset($search['tahun']) ? $search['tahun'] : $currentDate->year;

            $pengumuman = DataMaster::where('nama', 'pengumuman')->first();
            $tagihan = Pembayaran::with('subtagihan')->whereMonth('tanggal_pengajuan', $month)
                ->whereYear('tanggal_pengajuan', $year)
                ->where('kasir_id', auth()->user()->kasir->id)
                ->with('tagihan.pelanggan.areaAlamat')
                ->get();

            $status = DataMaster::where('nama', 'status_server')->first();

            return view('dashboard.index', [
                'pengumuman' => $pengumuman->data == "" ? "Tidak ada pengumuman" : $pengumuman->data,
                'tagihan' => $tagihan,
                'months' => $months,
                'years' => $years,
                'selectedYear' => $year,
                'status' => $status->data,
            ]);
        }

        abort(404);
    }
}
