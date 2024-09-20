<?php

namespace Tests\Unit;

use App\Models\Brand;
use App\Models\BrandModel;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ModelBrandTest extends TestCase
{
    use RefreshDatabase;

    function test_brand_model()
    {
        $brand = Brand::factory()->create();

        $this->assertDatabaseCount('brands', 1);

        $this->assertDatabaseHas('brands', [
            'id' => $brand->id,
        ]);
    }
}
