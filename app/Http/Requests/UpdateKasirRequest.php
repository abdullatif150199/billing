<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateKasirRequest extends FormRequest
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
            'id' => ['required'],
            'nama' => ['required', 'string'],
            'name' => ['required', 'string'],
            'areaAlamat' => ['required', Rule::exists('area_alamats', 'id')],
            'noTelpon' => ['required', 'string'],
            'password' => ['required', 'string'],
            'foto' => ['image'],
        ];
    }
}
