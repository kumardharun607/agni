<?php

namespace App\Http\Requests\DealerMapping;

use Illuminate\Foundation\Http\FormRequest;

class DealerMappingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // unique bde-per-dealer check only applies on create (matches original behaviour)
        $bdeUnique = $this->isMethod('post')
            ? 'unique:dealer_mappings,bde_id,NULL,id,dealer_id,' . $this->input('dealer_id')
            : '';

        return [
            'dealer_id' => ['required', 'exists:dealers,id'],
            'bde_id' => array_filter(['required', 'exists:users,id', $bdeUnique]),
        ];
    }
}
