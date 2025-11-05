<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TarefaRequest extends FormRequest
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
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'concluida' => 'sometimes|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required' => 'O campo título é obrigatório.',
            'titulo.string' => 'O campo título deve ser uma string.',
            'titulo.max' => 'O campo título não pode exceder 255 caracteres.',
            'descricao.string' => 'O campo descrição deve ser uma string.',
            'concluida.boolean' => 'O campo concluída deve ser verdadeiro ou falso.',
        ];
    }
}
