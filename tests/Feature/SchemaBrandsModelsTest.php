<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);


test('brand create', function () {
    $brand = \App\Models\Brand::factory()->create([
        'name' => 'Toyota',
        'slug' => 'toyota',
        'hash' => md5('toyota'),
    ]);

    $this->assertDatabaseCount('brands', 1);

    $this->assertDatabaseHas('brands', [
        'id' => $brand->id,
    ]);

});