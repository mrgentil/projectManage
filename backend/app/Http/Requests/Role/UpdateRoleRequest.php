<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return ['name' => 'required|string|unique:roles,name,' . $this->role->id];
    }
}

