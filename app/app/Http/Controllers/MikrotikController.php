<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMikrotikCredentialsRequest;
use App\Models\DataMaster;
use App\Services\MikrotikService;
use App\Services\TagihanService;
use Exception;
use Illuminate\Http\Request;

class MikrotikController extends Controller
{
    public function index()
    {
        $mikrotik = DataMaster::where('nama', 'mikrotik')->first();

        return view('mikrotik.index', [
            'mikrotik' => json_decode($mikrotik['data'], true),
        ]);
    }

    public function update(StoreMikrotikCredentialsRequest $request, TagihanService $tagihanService)
    {
        $data = $request->validated();

        try {
            $client = new MikrotikService($data);
            $tagihanService->refreshIsolirAll();
        } catch (Exception) {
            return redirect()->back()->with('message', [
                'status' => 'failed',
                'message' => 'Gagal mencoba koneksi ke mikrotik, kemungkinan salah dalam melakukan pengisian!',
            ]);
        }

        $mikrotik = DataMaster::where('nama', 'mikrotik')->first();
        $mikrotik->fill([
            'data' => json_encode($data),
        ]);

        return $mikrotik->save() ? redirect()->back()->with('message', [
            'status' => 'success',
            'message' => 'Data mikrotik berhasil diupdate!',
        ]) : redirect()->back()->with('message', [
            'status' => 'failed',
            'message' => 'Data mikrotik gagal diupdate!',
        ]);
    }
}
