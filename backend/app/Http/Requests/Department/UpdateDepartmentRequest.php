<?php


namespace App\Http\Requests\Department;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDepartmentRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules() {
        return [
            'name' => 'required|string|unique:departments,name,' . $this->route('department')->id,

        ];
    }
}

