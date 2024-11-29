<?php

namespace App\Http\Requests\V1\Order;

use App\Enums\Order\DeliveryTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'address' => [
                'required',
                'array',
            ],
            'address.street' => [
                'required',
                'string',
                'max:255',
            ],
            'address.number' => [
                'required',
                'string',
                'max:20',
            ],
            'address.complement' => [
                'nullable',
                'string',
                'max:100',
            ],
            'address.neighborhood' => [
                'required',
                'string',
                'max:100',
            ],
            'address.city' => [
                'required',
                'string',
                'max:100',
            ],
            'address.state' => [
                'required',
                'string',
                'max:2',
            ],
            'address.postcode' => [
                'required',
                'string',
                'max:9',
            ],
            'client' => [
                'required',
                'array',
            ],
            'client.name' => [
                'required',
                'string',
                'max:255',
            ],
            'client.email' => [
                'required',
                'email',
                'max:255',
            ],
            'client.phone' => [
                'required',
                'string',
                'max:30',
            ],
            'deliveryType' => [
                'required',
                'string',
                Rule::in(DeliveryTypeEnum::values())
            ],
            'observation' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'items' => [
                'required',
                'array',
                'min:1'
            ],
            'items.*.productId' => [
                'required',
                'integer',
                'exists:products,id',
            ],
            'items.*.quantity' => [
                'required',
                'integer',
                'min:1',
            ],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
