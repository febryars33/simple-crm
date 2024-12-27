<?php

namespace App\Http\Requests\Employee;

use App\Models\Employee;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
        $employee = $this->route('employee');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'nik' => [
                'required',
                'digits:16',
                Rule::unique(Employee::class)->ignore($employee),
            ],
            'phone' => ['required',
                'phone:ID',
                Rule::unique(Employee::class)->ignore($employee),
            ],
            'birth_place' => [
                'required',
                'string',
                'max:255',
            ],
            'birth_date' => [
                'required',
                'date',
            ],
            'address' => [
                'required',
                'string',
                'max:255',
            ],
        ];
    }
}
