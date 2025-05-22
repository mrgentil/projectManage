<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class AddUserToProjectRequest extends FormRequest
{
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'user_id' => 'required|exists:users,id',
            'role_in_project' => 'required|string|max:100',
        ];
    }
}
