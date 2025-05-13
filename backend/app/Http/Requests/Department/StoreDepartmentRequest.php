<?php


namespace App\Http\Requests\Department;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepartmentRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules() {
        return [
            'name' => 'required|string|unique:departments,name',

        ];
    }
}

