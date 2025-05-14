<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // ou ajouter une Policy plus tard
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:projects,name',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'nullable|in:En cours,En progression,Achevé',
            'priority' => 'nullable|in:Faible,Moyen,Elevé,Urgent',
            'client_name' => 'nullable|string|max:255',
            'budget' => 'nullable|numeric|min:0',
            'manager_id' => 'required|exists:users,id',
        ];
    }
}

