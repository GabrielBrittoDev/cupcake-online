<?php

namespace Database\Factories\Product;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->sentence,
            'ingredients' => $this->faker->sentence,
            'price' => $this->faker->randomFloat(2, 0, 1000),
            'imagePath' => $this->faker->imageUrl(),
            'active' => $this->faker->boolean,
        ];
    }

    public function active(): self
    {
        return $this->state(fn () => ['active' => true]);
    }
}
