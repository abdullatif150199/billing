<?php

namespace App\Http\Requests;

use App\Rules\AscDescRule;
use Illuminate\Foundation\Http\FormRequest;

class TagihanSearchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'bulan' => ['numeric'],
            'tahun' => ['numeric'],
            'namaNId' => ['alpha_num'],
            'alamat' => ['numeric'],
            'sort' => ['alpha_num'],
            'order' => ['alpha_num', new AscDescRule]
        ];
    }
}
