<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BrandModel>
 */
class BrandFactory extends Factory
{

    protected $model = Brand::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $brandName = fake()->company;

        return [
            'name' => $brandName,
            'slug' => Str::slug(Str::limit($brandName, 100, ''), '-'),
            'hash' => md5($brandName),
        ];
    }
}
