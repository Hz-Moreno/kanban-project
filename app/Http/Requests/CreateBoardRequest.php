<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBoardRequest extends FormRequest
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
            'name' => ['string', 'required'],
            'user_id' => ['string', 'required'],
        ];
    }

    public function messages(): array
    {
        return[
            'name.required' => 'O campo nome é obrigatório!',
            'name.string' => 'O campo nome deve ser uma string válida!',
            'user_id.required' => 'O id do usuario é obrigatório!',
            'user_id.string' => 'O id do usuario deve ser um string válida!'
        ]
    }
}
