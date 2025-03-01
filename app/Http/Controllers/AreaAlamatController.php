<?php

namespace App\Http\Controllers;

use App\Models\AreaAlamat;
use App\Http\Requests\StoreAreaAlamatRequest;
use App\Http\Requests\UpdateAreaAlamatRequest;
use Illuminate\Http\RedirectResponse;

class AreaAlamatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $areaAlamat = AreaAlamat::orderBy('nama', 'asc')->get();
        return view('area-alamat.index', [
            'areaAlamat' => $areaAlamat,
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
    public function store(StoreAreaAlamatRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if (AreaAlamat::create($data)) {
            return redirect()->route('alamat.index')->with('message', [
                'status' => 'success',
                'message' => 'Alamat / Area berhasil ditambahkan',
            ]);
        }

        return redirect()->route('alamat.index')->with('message', [
            'status' => 'failed',
            'message' => 'Alamat / Area gagal ditambahkan',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(AreaAlamat $areaAlamat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AreaAlamat $alamat)
    {
        return view('area-alamat.edit', [
            'data' => $alamat,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAreaAlamatRequest $request, AreaAlamat $alamat): RedirectResponse
    {
        $data = $request->validated();
        $alamat->fill($data);

        if ($alamat->save()) {
            return redirect()->route('alamat.index')->with('message', [
                'status' => 'success',
                'message' => 'Alamat / Area berhasil di edit',
            ]);
        }

        return redirect()->route('alamat.index')->with('message', [
            'status' => 'success',
            'message' => 'Alamat / Area gagal di edit',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AreaAlamat $alamat): RedirectResponse
    {
        if ($alamat->destroy($alamat->id)) {
            return redirect()->route('alamat.index')->with('message', [
                'status' => 'success',
                'message' => 'Alamat / Area berhasil dihapus',
            ]);
        }

        return redirect()->route('alamat.index')->with('message', [
            'status' => 'failed',
            'message' => 'Alamat / Area gagal dihapus',
        ]);
    }
}
