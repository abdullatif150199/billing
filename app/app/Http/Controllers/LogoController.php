<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLogoRequest;
use App\Models\DataMaster;
use Illuminate\Support\Facades\Storage;

class LogoController extends Controller
{
    protected string $LOGO_DIRECTORY = 'public/logo';

    public function create()
    {
        return view('logo.form');
    }

    public function store(StoreLogoRequest $request)
    {
        $data = $request->validated();
        $logo = DataMaster::where('nama', 'logo')->first();

        if ($logo->data != "") {
            Storage::delete($logo->data);
        }

        $logoPath = $data['logo']->storePublicly($this->LOGO_DIRECTORY);
        $logo->data = $logoPath;

        if ($logo->save()) {
            return redirect()
                ->route('logo.create')
                ->with('message', [
                    'status' => 'success',
                    'message' => 'Logo berhasil disimpan'
                ]);
        }

        return redirect()
            ->route('logo.create')
            ->with('message', [
                'status' => 'failed',
                'message' => 'Logo gagal disimpan'
            ]);
    }
}
