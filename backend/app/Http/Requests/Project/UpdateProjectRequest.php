<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $projectId = $this->route('project')->id ?? null;

        return [
            'name' => 'required|string|max:255|unique:projects,name,' . $projectId,
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

