<?php

namespace App\Http\Requests\V1\Order;

use App\Enums\Order\DeliveryTypeEnum;
use App\Enums\Order\StatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::in(StatusEnum::values()),
            ],
            'deliveryType' => [
                'sometimes',
                'string',
                Rule::in(DeliveryTypeEnum::values()),
            ],
            'observation' => [
                'sometimes',
                'nullable',
                'string',
                'max:1000',
            ],
            'total' => [
                'sometimes',
                'numeric',
                'min:0',
            ],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
