<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePengumumanRequest;
use App\Models\DataMaster;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function create()
    {
        return view('pengumuman.form', [
            'pengumuman' => DataMaster::where('nama', 'pengumuman')->first(),
        ]);
    }

    /**
     * Handle the incoming request.
     */
    public function store(StorePengumumanRequest $request)
    {
        $validated = $request->validated();

        DataMaster::where('nama', 'pengumuman')
            ->first()
            ->fill(['data' => $validated['pengumuman']])
            ->save();

        return redirect()
            ->route('pengumuman.create')
            ->with('message', [
                'status' => 'success',
                'message' => 'Pengumuman berhasil dikirim!',
            ]);
    }
}
