<?php

namespace App\Http\Controllers;

use App\Enums\StatusServer;
use App\Models\DataMaster;
use Illuminate\Http\Request;

class StatusKoneksiServerController extends Controller
{
    public function index()
    {
        return view('status-server.index', [
            'status' => DataMaster::where('nama', 'status_server')->first(),
        ]);
    }

    public function store()
    {
        $status = DataMaster::where('nama', 'status_server')->first();
        $status->fill([
            'data' => $status->data == StatusServer::Normal->value ? StatusServer::SedangAdaGanguan->value : StatusServer::Normal->value
        ]);

        if ($status->save()) {
            return redirect()
                ->back()
                ->with('message', [
                    'status' => 'success',
                    'message' => 'Berhasil update status server',
                ]);
        }

        return redirect()
            ->back()
            ->with('message', [
                'status' => 'failed',
                'message' => 'Gagal update status server',
            ]);
    }
}
