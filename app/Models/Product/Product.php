<?php

namespace App\Models\Product;

use App\Models\BaseModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $ingredients
 * @property float $price
 * @property string $imagePath
 * @property bool $active
 * @property Carbon $createdAt
 * @property Carbon $updatedAt
 *
 * @property-read string $imageLink
 */
class Product extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'ingredients',
        'price',
        'imagePath',
        'active',
    ];

    protected $appends = [
        'imageLink',
    ];

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
        ];
    }

    public function getImageLinkAttribute(): string
    {
        return asset('storage/' . $this->imagePath);
    }
}
