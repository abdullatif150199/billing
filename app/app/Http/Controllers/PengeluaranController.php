<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use App\Http\Requests\StorePengeluaranRequest;
use App\Http\Requests\UpdatePengeluaranRequest;

class PengeluaranController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePengeluaranRequest $request)
    {
        $data = $request->validated();

        $month = isset($data['bulan']) ? $data['bulan'] : now()->month;
        $year = isset($data['tahun']) ? $data['tahun'] : now()->year;

        $tanggalPengeluaran = now();
        $tanggalPengeluaran->month($month);
        $tanggalPengeluaran->year($year);

        $pengeluaranData = [
            'nama' => $data['nama'],
            'total' => $data['total'],
            'tanggal_pengeluaran' => $tanggalPengeluaran,
        ];

        if (Pengeluaran::create($pengeluaranData)) {
            return redirect()->back()->with('message', [
                'status' => 'success',
                'message' => 'Pengeluaran berhasil ditambah!',
            ]);
        }

        return redirect()->back()->with('message', [
            'status' => 'failed',
            'message' => 'Pengeluaran gagal ditambah!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengeluaran $pengeluaran)
    {
        return $pengeluaran->delete() ?
            redirect()->back()->with('message', [
                'status' => 'success',
                'message' => 'Hapus pengeluaran berhasil!'
            ]) : redirect()->back()->with('message', [
                'status' => 'failed',
                'message' => 'Hapus pengeluaran gagal!',
            ]);
    }
}
