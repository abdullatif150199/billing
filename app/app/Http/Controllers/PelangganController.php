<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Http\Requests\StorePelangganRequest;
use App\Http\Requests\UpdatePelangganRequest;
use App\Jobs\RefreshTagihanJob;
use App\Models\AreaAlamat;
use App\Models\PaketLangganan;
use App\Services\PelangganService;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input();
        $query = Pelanggan::with('user')->with('paketLangganan')->with('areaAlamat');

        if ($request->session()->has('search') && !$search) {
            $search = $request->session()->get('search');
            $request->session()->forget('search');
        } else {
            $request->session()->flash('search', $search);
        }

        if (isset($search['alamat'])) {
            $query->where('area_alamat_id', $search['alamat']);
        }

        if (isset($search['nama'])) {
            $query->where('nama', 'like', "%{$search['nama']}%");
        }

        return view('pelanggan.index', [
            'nama' => $search['nama'] ?? '',
            'alamatId' => $search['alamat'] ?? null,
            'alamat' => AreaAlamat::all(),
            'pelanggan' => $query->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pelanggan.form', [
            'paket' => PaketLangganan::all(),
            'areaAlamat' => AreaAlamat::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePelangganRequest $request, PelangganService $service)
    {
        $data = $request->validated();

        if ($service->save($data)) {
            RefreshTagihanJob::dispatch(now());

            return redirect()
                ->route('pelanggan.index')
                ->with('message', [
                    'status' => 'success',
                    'message' => 'Data Pelanggan berhasil ditambah!',
                ]);
        }

        return redirect()
            ->route('pelanggan.create')
            ->with('message', [
                'status' => 'failed',
                'message' => 'Data Pelanggan gagal ditambah!',
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Pelanggan $pelanggan)
    {
        $request->session()->reflash();

        return view('pelanggan.show', [
            'pelanggan' => $pelanggan,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Pelanggan $pelanggan)
    {
        $request->session()->reflash();

        return view('pelanggan.form', [
            'paket' => PaketLangganan::all(),
            'areaAlamat' => AreaAlamat::all(),
            'pelanggan' => $pelanggan,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePelangganRequest $request, Pelanggan $pelanggan, PelangganService $service)
    {
        $request->session()->reflash();

        $data = $request->validated();

        return $service->update($pelanggan, $data) ?
            redirect()->route('pelanggan.index')->with('message', [
                'status' => 'success',
                'message' => 'Data pelanggan berhasil diedit!',
            ]) :
            redirect()->route('pelanggan.index')->with('message', [
                'status' => 'failed',
                'message' => 'Data pelanggan gagal diedit!',
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Pelanggan $pelanggan, PelangganService $service)
    {
        $request->session()->reflash();

        return $service->delete($pelanggan) ?
            redirect()->route('pelanggan.index')->with('message', [
                'status' => 'success',
                'message' => 'Data pelanggan berhasil dihapus!',
            ]) :
            redirect()->route('pelanggan.index')->with('message', [
                'status' => 'failed',
                'message' => 'Data pelanggan gagal dihapus!',
            ]);
    }
}
