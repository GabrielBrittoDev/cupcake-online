<?php

namespace App\Models\Order;

use App\Models\Address;
use App\Models\BaseModel;
use App\Models\Client\Client;
use App\Models\Product\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $orderId
 * @property int $productId
 * @property int $quantity
 * @property float $total
 * @property Carbon $createdAt
 * @property Carbon $updatedAt
 * @property Order $order
 * @property Product $product
 */
class OrderItem extends BaseModel
{
    protected $table = 'orders_items';
    protected $fillable = [
        'orderId',
        'productId',
        'quantity',
        'total',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'productId');
    }
}
