<?php

namespace App\Actions;

use App\Models\Brand;
use App\Models\BrandModel;
use Illuminate\Support\Str;

class ImportModelsAction
{
    public function handle()
    {
        $file_path = database_path('imports/models.json');
        $file_content = file_get_contents($file_path);
        $content = collect(json_decode($file_content, associative: true));

        $content->groupBy('brand_name')->each(function ($item, $brand_name) {
            $brand = $this->createBrand(brand_name: $brand_name);

            $models = collect($item)->map(fn ($item) => [
                'id' => $item['id'],
                'brand_id' => $brand->id,
                'name' => $item['name'],
                'slug' => Str::slug($item['name'], '-'),
                'average_price' => $item['average_price']
            ])->toArray();

            BrandModel::insert($models);
        });
    }

    public function createBrand(string $brand_name)
    {
        return Brand::create([
            'name' => $brand_name,
            'slug' => Str::slug($brand_name, '-'),
        ]);
    }
}