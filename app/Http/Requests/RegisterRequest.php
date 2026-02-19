<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', Password::min(5)->letters()->numbers()],
        ];
    }

    /**
     * Return cool messages error to validator
     */
    public function messages(): array
    {
        return [
            'name.required' => 'O campo nome é obrigatório!',
            'email.required' => 'O campo email é obrigatório!',
            'email.email' => 'O campo email deve ser preenchido com um e-mail válido!',
            'email.unique' => 'Este e-mail já está sendo utilizado.',
            'password.required' => 'O campo senha é obrigatório!',
            'password.min' => 'O campo senha deve possuir ao menos 5 caracteres!',
        ];
    }
}
