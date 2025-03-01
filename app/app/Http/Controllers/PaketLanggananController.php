<?php

namespace App\Http\Controllers;

use App\Models\PaketLangganan;
use App\Http\Requests\StorePaketLanggananRequest;
use App\Http\Requests\UpdatePaketLanggananRequest;

class PaketLanggananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('paket-langganan.index', [
            'paketLangganan' => PaketLangganan::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaketLanggananRequest $request)
    {
        $data = $request->validated();
        if (PaketLangganan::create($data)) {
            return redirect()->route('paket-langanan.index')->with('message', [
                'status' => 'success',
                'message' => 'Paket Pelanggan berhasil dibuat',
            ]);
        }


        return redirect()->route('paket-langanan.index')->with('message', [
            'status' => 'failed',
            'message' => 'Paket Pelanggan gagal dibuat',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(PaketLangganan $paketLangganan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaketLangganan $paketLanganan)
    {
        return view('paket-langganan.edit', [
            'data' => $paketLanganan,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaketLanggananRequest $request, PaketLangganan $paketLanganan)
    {
        $data = $request->validated();

        $paketLanganan->fill($data);

        if ($paketLanganan->save()) {
            return redirect()->route('paket-langanan.index')->with('message', [
                'status' => 'success',
                'message' => 'Paket pelanggan berhasil diupdate!',
            ]);
        }

        return redirect()->route('paket-langanan.index')->with('message', [
            'status' => 'failed',
            'message' => 'Paket pelanggan berhasil diupdate!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaketLangganan $paketLanganan)
    {
        if ($paketLanganan->destroy($paketLanganan->id)) {
            return redirect()->route('paket-langanan.index')->with('message', [
                'status' => 'success',
                'message' => 'Paket pelanggan berhasil dihapus!',
            ]);
        }

        return redirect()->route('paket-langanan.index')->with('message', [
            'status' => 'failed',
            'message' => 'Paket pelanggan gagal dihapus!',
        ]);
    }
}
