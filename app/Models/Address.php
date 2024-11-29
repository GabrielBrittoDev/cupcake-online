<?php

namespace App\Models;

use App\Models\Client\Client;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $street
 * @property string $neighborhood
 * @property string $city
 * @property string $state
 * @property string $postcode
 * @property string|null $complement
 * @property int $clientId
 * @property Carbon $createdAt
 * @property Carbon $updatedAt
 */
class Address extends BaseModel
{
    protected $fillable = [
        'street',
        'neighborhood',
        'city',
        'state',
        'number',
        'postcode',
        'complement',
        'clientId'
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
