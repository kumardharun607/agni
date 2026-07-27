<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user')?->id;

        return [
            'emp_code' => ['required', 'string', 'max:50', 'unique:users,emp_code,' . $userId],
            'role_id' => ['required', 'exists:roles,id'],
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'max:15', 'unique:users,mobile,' . $userId],
            'country_id' => ['nullable', 'exists:countries,id'],
            'state_id' => ['nullable', 'exists:states,id'],
            'city_id' => ['nullable', 'exists:cities,id'],
            'pincode_id' => ['nullable', 'exists:pincodes,id'],
            'address' => ['nullable', 'string'],
            'doj' => ['nullable', 'date'],
            'dob' => ['nullable', 'date'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $userId],
        ];
    }
}
