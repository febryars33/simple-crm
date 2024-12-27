<?php

namespace App\Http\Requests\Company;

use App\Models\Company;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
            ],
            'email' => [
                'required', 'unique:'.Company::class.',email',
            ],
            'phone' => [
                'required', 'unique:'.Company::class.',phone',
            ],
            'address' => [
                'required',
            ],
        ];
    }
}
