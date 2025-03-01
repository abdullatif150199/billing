<?php

namespace App\Http\Controllers;

use App\Models\Kasir;
use App\Http\Requests\StoreKasirRequest;
use App\Http\Requests\UpdateKasirRequest;
use App\Models\AreaAlamat;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class KasirController extends Controller
{

    protected string $FOTO_DIR = 'public/foto-kasir';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kasir = Kasir::with('user')->with('areaAlamat');

        return view('kasir.index', [
            'kasir' => $kasir->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kasir.form', [
            'areaAlamat' => AreaAlamat::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKasirRequest $request)
    {
        $data = $request->validated();

        $data['foto'] = $data['foto']->storePublicly($this->FOTO_DIR);
        if (!$data['foto']) {
            Log::error("Foto gagal disimpan");
            return redirect()->back()
                ->with('message', [
                    'status' => 'failed',
                    'message' => 'Simpan gambar gagal'
                ]);
        }

        $user = User::create([
            'name' => $data['name'],
            'password' => $data['password'],
            'password_not_hashed' => $data['password'],
            'no_telpon' => $data['noTelpon'],
            'foto' => $data['foto'],
        ]);

        $user->assignRole('koordinator');

        if (!$user) {
            Log::error("User Model gagal dibuat");
            Storage::delete($data['foto']);
            return redirect()->back()
                ->with('message', [
                    'status' => 'failed',
                    'message' => 'Gagal untuk menyimpan kasir!',
                ]);
        }

        $kasir = $user->kasir()->create([
            'id' => $data['id'],
            'area_alamat_id' => $data['areaAlamat'],
            'nama' => $data['nama'],
        ]);

        if (!$kasir) {
            Log::error("Kasir Model gagal dibuat");
            Storage::delete($data['foto']);
            return redirect()->back()
                ->with('message', [
                    'status' => 'failed',
                    'message' => 'Gagal untuk menyimpan kasir!',
                ]);
        }

        return redirect()->route('kasir.index')
            ->with('message', [
                'status' => 'success',
                'message' => 'Berhasil untuk menyimpan kasir!',
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Kasir $kasir)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kasir $kasir)
    {
        return view('kasir.form', [
            'areaAlamat' => AreaAlamat::all(),
            'kasir' => $kasir,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKasirRequest $request, Kasir $kasir)
    {
        $data = $request->validated();

        $rules = [];
        if ($data['id'] != $kasir->id) {
            $rules['id'] = 'unique:kasirs,id';
        }

        if ($data['name'] != $kasir->user->name) {
            $rules['name'] = 'unique:users,name';
        }

        if ($rules) {
            Validator::make($data, $rules);
        }

        $userData = [
            'name' => $data['name'],
            'password' => $data['password'],
            'password_not_hashed' => $data['password'],
            'no_telpon' => $data['noTelpon'],
        ];

        $kasirData = [
            'id' => $data['id'],
            'area_alamat_id' => $data['areaAlamat'],
            'nama' => $data['nama'],
        ];

        if (isset($data['foto'])) {
            Storage::delete($kasir->user->foto);
            $data['foto'] = $data['foto']->storePublicly($this->FOTO_DIR);

            if (!$data['foto']) {
                Log::error("Foto gagal disimpan");
                return redirect()->back()
                    ->with('message', [
                        'status' => 'failed',
                        'message' => 'Simpan gambar gagal'
                    ]);
            }

            $user['foto'] = $data['foto'];
        }

        $user = $kasir->user;
        $user->fill($userData);
        if (!$user->save()) {
            Log::error("User gagal di update");
            return redirect()->back()
                ->with('message', [
                    'status' => 'failed',
                    'message' => 'User gagal di update'
                ]);
        }

        $kasir = $kasir->fill($kasirData);
        if (!$kasir->save()) {
            Log::error("Kasir gagal di update");
            return redirect()->back()
                ->with('message', [
                    'status' => 'failed',
                    'message' => 'Kasir gagal di update'
                ]);
        }

            return redirect()->route('kasir.index')
                ->with('message', [
                    'status' => 'success',
                    'message' => 'Kasir berhasil di update'
                ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kasir $kasir)
    {
        Storage::delete($kasir->user->foto);

        $kasir->user->removeRole('koordinator');

        return $kasir->user->delete() ?
            redirect()->back()
            ->with('message', [
                'status' => 'success',
                'message' => 'Hapus kasir sukses',
            ]) : redirect()->back()
            ->with('message', [
                'status' => 'failed',
                'message' => 'Hapus kasir gagal',
            ]);
    }
}
