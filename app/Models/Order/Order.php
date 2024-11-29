<?php

namespace App\Models\Order;

use App\Enums\Order\DeliveryTypeEnum;
use App\Enums\Order\StatusEnum;
use App\Models\Address;
use App\Models\BaseModel;
use App\Models\Client\Client;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $clientId
 * @property int $addressId
 * @property float $total
 * @property StatusEnum $status
 * @property ?string $observation
 * @property DeliveryTypeEnum $deliveryType
 * @property ?Carbon $deliveredAt
 * @property Carbon $createdAt
 * @property Carbon $updatedAt
 * @property Client $client
 * @property Address $address
 * @property Collection<OrderItem> $items
 */
class Order extends BaseModel
{
    protected $fillable = [
        'clientId',
        'addressId',
        'total',
        'status',
        'observation',
        'deliveryType',
        'deliveredAt',
    ];

    protected $casts = [
        'deliveredAt' => 'datetime',
        'deliveryType' => DeliveryTypeEnum::class,
        'status' => StatusEnum::class,
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'clientId');
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'addressId');
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'orderId');
    }
}
