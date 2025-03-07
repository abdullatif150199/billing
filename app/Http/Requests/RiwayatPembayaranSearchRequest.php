<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RiwayatPembayaranSearchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->hasRole('pelanggan');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'tahun' => ['numeric'],
        ];
    }
}
