<?php

namespace App\Http\Controllers;

use App\Http\Requests\KasirUpdateRequest;
use App\Http\Requests\PelangganUpdateProfileRequest;
use App\Http\Requests\UpdateAdminProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    protected string $FOTO_DIRECTORY = 'public/foto';

    public function show()
    {
        return view('profile.show', [
            'profile' => auth()->user(),
        ]);
    }

    public function updateAdmin(UpdateAdminProfileRequest $request)
    {
        $data = $request->validated();
        $user = auth()->user();

        $user->fill([
            'name' => $data['name'],
            'password' => $data['password'],
            'no_telpon' => $data['noWhatsapp'],
            'foto' => $data['foto']->storePublicly($this->FOTO_DIRECTORY),
        ]);

        if ($user->save()) {
            return redirect()
                ->route('profile.show')
                ->with('message', [
                    'status' => 'success',
                    'message' => 'Profil berhasil diubah!',
                ]);
        }

        return redirect()
            ->route('profile.show')
            ->with('message', [
                'status' => 'failed',
                'message' => 'Profil gagal diubah!',
            ]);
    }

    public function updatePelanggan(PelangganUpdateProfileRequest $request)
    {
        $data = $request->validated();
        $user = auth()->user();

        $user->fill([
            'name' => $data['name'],
            'password' => $data['password'],
            'password_not_hashed' => $data['password'],
            'no_telpon' => $data['noWhatsapp'],
        ]);

        if ($user->save()) {
            return redirect()
                ->route('profile.show')
                ->with('message', [
                    'status' => 'success',
                    'message' => 'Profil berhasil diubah!',
                ]);
        }

        return redirect()
            ->route('profile.show')
            ->with('message', [
                'status' => 'failed',
                'message' => 'Profil gagal diubah!',
            ]);
    }

    public function updateKoordinator(KasirUpdateRequest $request)
    {
        $data = $request->validated();
        $user = auth()->user();

        $user->fill([
            'name' => $data['name'],
            'password' => $data['password'],
            'password_not_hashed' => $data['password'],
            'no_telpon' => $data['noWhatsapp'],
        ]);

        if ($user->save()) {
            return redirect()
                ->route('profile.show')
                ->with('message', [
                    'status' => 'success',
                    'message' => 'Profil berhasil diubah!',
                ]);
        }

        return redirect()
            ->route('profile.show')
            ->with('message', [
                'status' => 'failed',
                'message' => 'Profil gagal diubah!',
            ]);
    }
}
