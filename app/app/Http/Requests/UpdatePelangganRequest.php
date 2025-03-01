<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePelangganRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'nama' => ['required'],
            'id' => ['required'],
            'nomerTelpon' => ['required'],
            'tanggalRegister' => ['required', 'date'],
            'tanggalTagihan' => ['required', 'numeric'],
            'tanggalJatuhTempo' => ['required', 'numeric'],
            'paketLangganan' => ['required', 'exists:paket_langganans,id'],
            'areaAlamat' => ['required'],
            'googleMap' => ['required'],
            'ipAddress' => ['required', 'ip'],
            'serialNumberModem' => ['required'],
            'fotoRumah' => ['image'],
            'fotoKtp' => ['image'],
            'name' => ['required'],
            'password' => ['required', 'alpha_num'],
        ];
    }
}
