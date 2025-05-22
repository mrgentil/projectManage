<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class RemoveUserFromProjectRequest extends FormRequest
{
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'user_id' => 'required|exists:users,id',
        ];
    }
}

