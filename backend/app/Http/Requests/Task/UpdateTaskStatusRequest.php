<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'status' => 'required|in:En cours,En progression,Achevé',
        ];
    }

    public function messages(): array
    {
        return [
            'status.in' => 'Le statut doit être "En cours", "En progression" ou "Achevé".',
        ];
    }
}

