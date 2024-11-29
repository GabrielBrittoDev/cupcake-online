<?php

namespace App\Http\Requests\V1\Product;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'page' => [
                'sometimes',
                'integer',
                'min:1',
            ],
            'perPage' => [
                'sometimes',
                'integer',
                'min:1',
            ],
            'search' => [
                'sometimes',
                'nullable',
                'string',
                'max:255',
            ],
            'active' => [
                'sometimes',
                'boolean',
            ],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
