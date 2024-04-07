<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
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
            'id' => [
                'required',
                Rule::exists('tasks', 'id'),
            ],
            'taskName' => 'nullable|string|max:255',
            'taskDescription' => 'nullable|string',
            'finished' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'taskName.required' => 'O nome é obrigatório',
            'taskName.string' => 'O nome deve ser uma string',
            'taskName.max' => 'Deve ter no máximo 255 caracteres',
            'description.string' => 'A descrição deve ser uma string',
        ];
    }
}
