<?php

namespace App\Http\Requests\V1\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'sometimes',
                'string',
                'max:255',
            ],
            'description' => [
                'sometimes',
                'string',
                'max:1000',
            ],
            'price' => [
                'sometimes',
                'numeric',
                'min:0',
            ],
            'images' => [
                'sometimes',
                'array',
            ],
            'images.*' => [
                'sometimes',
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
