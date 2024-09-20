<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_api_model_successful_response(): void
    {
        $response = $this->getJson('/models');

        $response->assertStatus(200);
    }

    /**
     * API Create model
     */
    public function test_api_create_model_successful_response(): void
    {
        $response = $this->postJson('/brands', [
            'name' => 'KIA'
        ]);

        $response->assertStatus(201);

        $response->dump('id');

        $brand = $response->json('id');

        $response = $this->postJson("brands/$brand/models", [
            'name' => 'Kia Seltos 2024 SX',
            'average_price' => fake()->numberBetween(1, 9999999)
        ]);

        $response->dump();

        $response->assertStatus(201)->assertJsonPath('name', 'Kia Seltos 2024 SX');
    }

    /**
     * API Create model error when brand not found
     */
    public function test_api_create_model_brand_not_found_response(): void
    {
        $response = $this->postJson("brands/999999/models", [
            'name' => 'Kia Seltos 2024 SX',
            'average_price' => fake()->numberBetween(1, 9999999)
        ]);

        $response->assertStatus(404)
            ->assertJsonPath('message', 'Vehicle model not found.');
    }

    /**
     * API Create model error when model already exists
     */
    public function test_api_create_model_already_exists_response(): void
    {
        $response = $this->postJson('/brands', [
            'name' => 'KIA'
        ]);

        $response->assertStatus(201);

        $response->dump('id');

        $brand = $response->json('id');

        $response = $this->postJson("brands/$brand/models", [
            'name' => 'Kia Seltos 2024 SX',
            'average_price' => fake()->numberBetween(1, 9999999)
        ]);

        $response->assertStatus(201)->assertJsonPath('name', 'Kia Seltos 2024 SX');

        $response = $this->postJson("brands/$brand/models", [
            'name' => 'Kia Seltos 2024 SX',
            'average_price' => fake()->numberBetween(1, 9999999)
        ]);

        $response->assertStatus(422)->assertJsonPath('message', 'The name has already been taken.');
    }
}
