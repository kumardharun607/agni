<?php

namespace App\Http\Requests\DealerMapping;

use Illuminate\Foundation\Http\FormRequest;

class MapUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'parent_id' => ['required', 'exists:users,id'],
            'child_id' => ['required', 'exists:users,id', 'different:parent_id'],
        ];
    }
}
