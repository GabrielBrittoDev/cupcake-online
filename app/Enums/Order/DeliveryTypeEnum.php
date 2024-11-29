<?php

namespace App\Enums\Order;

use App\Enums\EnumHelperTrait;

enum DeliveryTypeEnum: string
{
    use EnumHelperTrait;

    case PENDING = 'pickup';
    case PROCESSING = 'delivery';
}
