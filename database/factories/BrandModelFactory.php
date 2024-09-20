<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\BrandModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BrandModel>
 */
class BrandModelFactory extends Factory
{
    protected $model = BrandModel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $brandName = fake()->company;

        return [
            'brand_id' => fake()->numberBetween(1,999999),
            'name' => $brandName,
            'slug' => Str::slug(Str::limit($brandName, 100, ''), '-'),
            'average_price' => fake()->numberBetween(100000, 999999),
        ];
    }
}
