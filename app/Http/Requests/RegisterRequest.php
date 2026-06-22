<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username'         => 'required|string|max:50|unique:user,username',
            'name'             => 'required|string|max:50',
            'first_last_name'  => 'required|string|max:50',
            'second_last_name' => 'nullable|string|max:50',
            'email'            => 'required|email|max:50|unique:user,email',
            'password'         => 'required|string|min:8|confirmed',
            'role_id'          => 'required|integer',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator): void
    {
        Log::warning("Fallo en validación de registro", [
            'datos_enviados' => $this->except('password', 'password_confirmation'),
            'errores'        => $validator->errors()
        ]);

        parent::failedValidation($validator);
    }
}
