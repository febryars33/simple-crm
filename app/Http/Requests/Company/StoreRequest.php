<?php

namespace App\Http\Requests\Company;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
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
            'employee.name' => [
                'required',
            ],
            'employee.nik' => [
                'required', 'digits:16', 'unique:'.Employee::class.',nik',
            ],
            'employee.phone' => [
                'required', 'phone:ID', 'unique:'.Employee::class.',phone',
            ],
            'employee.birth_place' => [
                'required', 'string',
            ],
            'employee.birth_date' => [
                'required', 'date',
            ],
            'employee.address' => [
                'required', 'string',
            ],
        ];
    }
}
