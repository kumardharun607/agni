<?php

namespace App\Http\Requests\PermissionDropdown;

use Illuminate\Foundation\Http\FormRequest;

class PermissionDropdownRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('permission_dropdown')?->id;

        return [
            'name' => ['required', 'string', 'max:255', 'unique:permission_dropdowns,name,' . $id],
        ];
    }
}
