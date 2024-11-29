<?php

namespace App\Enums\Order;

use App\Enums\EnumHelperTrait;

enum StatusEnum: string
{
    use EnumHelperTrait;

    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case COMPLETED = 'completed';
    case CANCELED = 'canceled';
}
