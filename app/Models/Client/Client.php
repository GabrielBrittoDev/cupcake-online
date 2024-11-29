<?php

namespace App\Models\Client;

use App\Models\Address;
use App\Models\BaseModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property Carbon $createdAt
 * @property Carbon $updatedAt
 *
 * @property-read Collection<Address> $addresses
 */
class Client extends BaseModel
{
    protected $fillable = [
        'name',
        'email',
        'phone',
    ];

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class, 'clientId');
    }
}
