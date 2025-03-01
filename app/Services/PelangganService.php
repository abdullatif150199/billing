<?php

namespace App\Services;

use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PelangganService
{
    protected string $DIRECTORY_KTP = 'public/ktp';
    protected string $DIRECTORY_RUMAH = 'public/rumah';

    // Save the pelanggan and its' assets
    public function save($data): bool
    {
        if (($fotoKtp = $this->storeKtp($data['fotoKtp'])) == false) {
            return false;
        }
        if (($fotoRumah = $this->storeRumah($data['fotoRumah'])) == false) {
            return false;
        }


        $user = [
            'name' => $data['name'],
            'password' => $data['password'],
            'password_not_hashed' => $data['password'],
            'no_telpon' => $data['nomerTelpon'],
            'foto' => $fotoKtp,
        ];

        $pelanggan = [
            'id' => $data['id'],
            'nama' => $data['nama'],
            'foto_rumah' => $fotoRumah,
            'serial_number_modem' => $data['serialNumberModem'],
            'tanggal_tagihan' => $data['tanggalTagihan'],
            'tanggal_jatuh_tempo' => $data['tanggalJatuhTempo'],
            'tanggal_register' => $data['tanggalRegister'],
            'google_map' => $data['googleMap'],
            'ip_address' => $data['ipAddress'],
            'paket_langganan_id' => $data['paketLangganan'],
            'area_alamat_id' => $data['areaAlamat']
        ];

        if (!($user = User::create($user))) {
            return false;
        }

        $user->assignRole('pelanggan');

        if (!($user->pelanggan()->create($pelanggan))) {
            return false;
        }

        return true;
    }

    public function update(Pelanggan $pelanggan, $data): bool
    {
        $validator = Validator::make($data, [
            'name' => 'unique:users,name',
        ]);

        $user = $pelanggan->user;

        $dataUserNew = [
            'name' => $data['name'],
            'password' => $data['password'],
            'no_telpon' => $data['nomerTelpon'],
        ];

        $dataPelangganNew = [
            'id' => $data['id'],
            'nama' => $data['nama'],
            'serial_number_modem' => $data['serialNumberModem'],
            'tanggal_tagihan' => $data['tanggalTagihan'],
            'tanggal_jatuh_tempo' => $data['tanggalJatuhTempo'],
            'tanggal_register' => $data['tanggalRegister'],
            'google_map' => $data['googleMap'],
            'ip_address' => $data['ipAddress'],
            'paket_langganan_id' => $data['paketLangganan'],
            'area_alamat_id' => $data['areaAlamat']
        ];

        if ($data['id'] != $pelanggan->id && $validator->validated()) {
            return false;
        }

        if (isset($data['fotoKtp'])) {
            if (($fotoKtp = $this->storeKtp($data['fotoKtp'])) == false) {
                return false;
            } else {
                $this->deleteKtp($user);
                $dataUserNew['foto'] = $fotoKtp;
            }
        }

        if (isset($data['fotoRumah'])) {
            if (($fotoRumah = $this->storeKtp($data['fotoRumah'])) == false) {
                return false;
            } else {
                $this->deleteFotoRumah($pelanggan);
                $dataPelangganNew['foto_rumah'] = $fotoRumah;
            }
        }

        $pelanggan->fill($dataPelangganNew);
        if (!($pelanggan->save())) {
            return false;
        }

        $user = $pelanggan->user;
        $user->fill($dataUserNew);
        if (!($user->save())) {
            return false;
        }

        return true;
    }

    // Clean up all pelanggan assets and delete the database record
    public function delete(Pelanggan $pelanggan): bool
    {
        $user = $pelanggan->user;
        $user->removeRole('pelanggan');
        $this->deleteAsset($pelanggan, $user);

        if (!($pelanggan->delete())) {
            return false;
        }

        if (!($user->delete())) {
            return false;
        }

        return false;
    }

    protected function deleteAsset(Pelanggan $pelanggan, User $user)
    {
        $this->deleteFotoRumah($pelanggan);
        $this->deleteKtp($user);
    }

    protected function deleteFotoRumah(Pelanggan $pelanggan)
    {
        if ($pelanggan->foto_rumah !=  null) {
            Storage::delete($pelanggan->foto_rumah);
        }
    }

    protected function deleteKtp(User $user)
    {
        if ($user->foto != null) {
            Storage::delete($user->foto);
        }
    }

    protected function storeKtp(UploadedFile $file): string|false
    {
        return $file->storePublicly($this->DIRECTORY_KTP);
    }

    protected function storeRumah(UploadedFile $file): string|false
    {
        return $file->storePublicly($this->DIRECTORY_RUMAH);
    }
}
