<?php

namespace App\Http\Controllers;

use App\Enums\StatusTagihan;
use App\Http\Requests\RiwayatSearchRequest;
use App\Http\Requests\TagihanSearchRequest;
use App\Models\AreaAlamat;
use App\Models\Pelanggan;
use App\Models\Tagihan;
use App\Services\TagihanService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TagihanController extends Controller
{
    public function index(TagihanSearchRequest $request)
    {
        $search = $request->validated();

        $currentDate = now();
        $months = array_map(fn ($month) => ['date' => Carbon::create(null, $month), 'selected' => false], range(1, 12));

        $activeMonthOffset = isset($search['bulan']) ? $search['bulan'] - 1 : $currentDate->month - 1;
        $months[$activeMonthOffset]['selected'] = true;

        $tagihan = Tagihan::with('pelanggan.areaAlamat')->with('subtagihan')->with('pelanggan.user')
            ->when(isset($search['namaNId']) ? $search['namaNId'] : null, function ($query, $search) {
                return $query->whereHas('pelanggan', function ($subQuery) use ($search) {
                    $subQuery->where('nama', 'like', "%{$search}%");
                    $subQuery->orWhere('id', 'like', "%{$search}%");
                });
            })
            ->when(isset($search['alamat']) ? $search['alamat'] : null, function ($query, $search) {
                return $query->whereHas('pelanggan.areaAlamat', function ($subQuery) use ($search) {
                    $subQuery->where('id', $search);
                });
            })
            ->whereYear('tanggal_tagihan', isset($search['tahun']) ? $search['tahun'] : $currentDate->year)
            ->whereMonth('tanggal_tagihan', isset($search['bulan']) ? $search['bulan'] : $currentDate->month);

        $years = DB::table('tagihans')->selectRaw('YEAR(`tanggal_tagihan`) as year')->groupBy('year')->get();

        $tagihan = $tagihan->get();
        if (isset($search['sort']) && isset($search['order'])) {
            $sort = $search['sort'];
            $order = $search['order'];
            $sortClosure = function (Tagihan $tagihan) use ($sort) {
                switch ($sort) {
                    case 'nama':
                        return $tagihan->pelanggan->nama;
                    case 'id':
                        return intval($tagihan->pelanggan->id);
                    case 'area':
                        return $tagihan->pelanggan->areaAlamat->nama;
                    case 'tagihan':
                        return $tagihan->getNominal();
                    case 'status':
                        return $tagihan->status_tagihan->name;
                    default:
                        return '';
                }
            };

            $tagihan = match ($order) {
                'asc' => $tagihan->sortBy($sortClosure)->values()->all(),
                'desc' => $tagihan->sortByDesc($sortClosure)->values()->all(),
            };
        }

        return view('tagihan.index', [
            'tagihan' => $tagihan,
            'alamat' => AreaAlamat::all(),
            'months' => $months,
            'years' => $years,
            'selectedYear' => isset($search['tahun']) ? $search['tahun'] : $currentDate->year,
            'namaNId' => isset($search['namaNId']) ? $search['namaNId'] : '',
            'alamatId' => isset($search['alamat']) ? $search['alamat'] : null,

            'sort' => isset($search['sort']) ? $search['sort'] : null,
            'order' => isset($search['order']) ? $search['order'] : null,
        ]);
    }

    public function bayar(Tagihan $tagihan, TagihanService $tagihanService)
    {
        $currentDate = now();

        if ($tagihanService->bayar($tagihan, $currentDate)) {
            try {
                $tagihanService->refreshIsolirStatus($tagihan);
            } catch (\Exception) {
                return redirect()->back()->with('message', [
                    'status' => 'failed',
                    'message' => 'Gagal men-update status isolir!',
                ]);
            }

            return redirect()
                ->back()
                ->with('message', [
                    'status' => 'success',
                    'message' => 'Tagihan berhasil dibayar!',
                ]);
        }

        return redirect()
            ->back()
            ->with('message', [
                'status' => 'failed',
                'message' => 'Tagihan gagal dibayar!',
            ]);
    }

    public function riwayat(RiwayatSearchRequest $request, Pelanggan $pelanggan)
    {
        $search = $request->validated();

        $currentDate = now();

        $years = DB::table('tagihans')->selectRaw('YEAR(`tanggal_tagihan`) as year')->where('pelanggan_id', $pelanggan->id)->groupBy('year')->get();
        $selectedYear = isset($search['tahun']) ? $search['tahun'] : $currentDate->year;

        $tagihan = $pelanggan->tagihan()->with('subtagihan')->whereYear('tanggal_tagihan', $selectedYear)->get();

        return view('tagihan.riwayat', [
            'pelanggan' => $pelanggan,
            'tagihan' => $tagihan,
            'years' => $years,
            'selectedYear' => $selectedYear,
        ]);
    }

    public function batal(Tagihan $tagihan, TagihanService $tagihanService)
    {
        if ($tagihanService->batal($tagihan, now())) {
            try {
                $tagihanService->refreshIsolirStatus($tagihan);
            } catch (\Exception) {
                return redirect()->back()->with('message', [
                    'status' => 'failed',
                    'message' => 'Gagal men-update status isolir!',
                ]);
            }

            return redirect()
                ->back()
                ->with('message', [
                    'status' => 'success',
                    'message' => 'Tagihan berhasil dibayar!',
                ]);
        }

        return redirect()
            ->back()
            ->with('message', [
                'status' => 'failed',
                'message' => 'Tagihan gagal dibayar!',
            ]);
    }

    public function show(Tagihan $tagihan)
    {
        return view('tagihan.show', [
            'tagihan' => $tagihan,
        ]);
    }
}
