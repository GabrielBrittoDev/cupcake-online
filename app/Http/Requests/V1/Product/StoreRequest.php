<?php

namespace App\Http\Requests\V1\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'required',
                'string',
                'max:1000',
            ],
            'ingredients' => [
                'required',
                'string',
                'max:1000',
            ],
            'price' => [
                'required',
                'numeric',
                'min:0',
            ],
            'image' => [
                'required',
                'file',
                'image',
            ],
            'active' => [
                'sometimes',
                'nullable',
                'boolean',
            ],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
