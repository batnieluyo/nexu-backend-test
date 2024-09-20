<?php

namespace Tests\Unit;

use App\Models\Brand;
use App\Models\BrandModel;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ModelBrandModelTest extends TestCase
{
    use RefreshDatabase;

    function test_model_brand_model()
    {
        $brand = Brand::factory()->create();

        $model = BrandModel::factory()->create(['brand_id' => $brand->id]);

        $this->assertTrue($brand->models->contains($model));

        $this->assertDatabaseCount('brand_models', 1);

        $this->assertDatabaseHas('brand_models', [
            'id' => $model->id,
        ]);
    }

}
