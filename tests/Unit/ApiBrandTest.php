<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

class ApiBrandTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_api_brand_successful_response(): void
    {
        $response = $this->get('/brands');

        $response->assertStatus(200);
    }

    /**
     * Create brand
     */
    public function test_api_create_brand_successful_response(): void
    {
        $response = $this->postJson('/brands', [
            'name' => 'Toyota'
        ]);

        $response->assertStatus(201)->assertJsonPath('name', 'Toyota');
    }

    /**
     * Validate the brand name are unique
     */
    public function test_api_validate_unique_name_brand(): void
    {
        $this->postJson('/brands', [
            'name' => 'Toyota'
        ]);

        $response = $this->postJson('/brands', [
            'name' => 'Toyota'
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonPath('message', 'The name has already been taken.');
    }

    /**
     * Show all the brands
     */
    public function test_api_list_brands(): void
    {
        $this->postJson('/brands', [
            'name' => 'Toyota'
        ]);

        $this->postJson('/brands', [
            'name' => 'KIA'
        ]);

        $response = $this->getJson('/brands');

        $response->assertStatus(200);

        $response
            ->assertJson(fn (AssertableJson $json) =>
                $json->has(2)->each(fn (AssertableJson $json) =>
                    $json->hasAll([ 'id', 'name', 'average_price'])
                )
            );
    }

    /**
     * A basic test example.
     */
    public function test_api_brand_with_average_price_successful_response(): void
    {
        $response = $this->postJson('/brands', [
            'name' => 'KIA'
        ]);

        $response->assertStatus(201);

        $brandId = $response->json('id');

        $avg_first = fake()->numberBetween(100000, 9999999);

        $this->postJson("brands/$brandId/models", [
            'name' => 'Kia Seltos 2024 SX',
            'average_price' => $avg_first
        ]);

        $response->assertStatus(201);

        $avg_second = fake()->numberBetween(100000, 9999999);

        $response = $this->postJson("brands/$brandId/models", [
            'name' => 'Kia Seltos 2025 SX',
            'average_price' => $avg_second
        ]);

        $response->assertStatus(201);

        $response = $this->get('/brands');

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json->has(1)->each(fn (AssertableJson $json) =>
                    $json->hasAll([ 'id', 'name', 'average_price'])
                )
            )->assertJsonPath(
                '0.average_price', (int) collect([$avg_first, $avg_second])->avg()
            );

    }
}
