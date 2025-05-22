<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'project_id' => 'required|exists:projects,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:En cours,En progression,Achevé',
            'priority' => 'required|in:Faible,Moyen,Elevé,Urgent',
            'due_date' => 'nullable|date',

            // Ajouts importants :
            'estimated_hours' => 'nullable|numeric|min:0',
            'actual_hours' => [
                'nullable',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) {
                    if ($this->estimated_hours && $value > $this->estimated_hours) {
                        $fail("Les heures réelles ne peuvent pas dépasser les heures estimées.");
                    }
                },
            ],

            'is_recurring' => 'nullable|boolean',

            // Utilisateurs assignés
            'user_ids' => 'nullable|array',
            'user_ids.*' => 'exists:users,id',
        ];
    }
}
