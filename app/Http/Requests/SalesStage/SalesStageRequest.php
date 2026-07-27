<?php

namespace App\Http\Requests\SalesStage;

use Illuminate\Foundation\Http\FormRequest;

class SalesStageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('sales_stage')?->id;

        return [
            'name' => ['required', 'string', 'max:255', 'unique:sales_stages,name,' . $id],
        ];
    }
}
