<?php

namespace Tests\Unit;

use Illuminate\Testing\Fluent\AssertableJson;
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

        $brand = $response->json('id');

        $response = $this->postJson("brands/$brand/models", [
            'name' => 'Kia Seltos 2024 SX',
            'average_price' => fake()->numberBetween(100000, 9999999)
        ]);

        $response->assertStatus(201)->assertJsonPath('name', 'Kia Seltos 2024 SX');
    }

    /**
     * API validate Create model with average_price lt 100,000
     */
    public function test_api_create_model_average_price_error_response(): void
    {
        $response = $this->postJson('/brands', [
            'name' => 'KIA'
        ]);

        $response->assertStatus(201);

        $brand = $response->json('id');

        $response = $this->postJson("brands/$brand/models", [
            'name' => 'Kia Seltos 2024 SX',
            'average_price' => fake()->numberBetween(1, 99999)
        ]);

        $response->assertStatus(422)
            ->assertJsonPath('message', 'The average price field must be at least 100000.');
    }

    /**
     * API validate create model pass with average_price field not present
     */
    public function test_api_create_model_average_price_not_present_successful_response(): void
    {
        $response = $this->postJson('/brands', [
            'name' => 'KIA'
        ]);

        $response->assertStatus(201);

        $brand = $response->json('id');

        $response = $this->postJson("brands/$brand/models", [
            'name' => 'Kia Seltos 2024 SX',
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('name', 'Kia Seltos 2024 SX')
            ->assertJsonPath('average_price', null);
    }

    /**
     * API validate create model  with average_price field present but is null
     */
    public function test_api_create_model_average_price_present_but_null_successful_response(): void
    {
        $response = $this->postJson('/brands', [
            'name' => 'KIA'
        ]);

        $response->assertStatus(201);

        $brand = $response->json('id');

        $response = $this->postJson("brands/$brand/models", [
            'name' => 'Kia Seltos 2024 SX',
            'average_price' => null
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('name', 'Kia Seltos 2024 SX')
            ->assertJsonPath('average_price', null);
    }

    /**
     * API validate create model  with average_price field present but is null
     */
    public function test_api_create_model_average_price_value_string_present_fail_response(): void
    {
        $response = $this->postJson('/brands', [
            'name' => 'KIA'
        ]);

        $response->assertStatus(201);

        $brand = $response->json('id');

        $response = $this->postJson("brands/$brand/models", [
            'name' => 'Kia Seltos 2024 SX',
            'average_price' => "TEST VALUE 100000"
        ]);

        $response->assertStatus(422)
            ->assertJsonPath('message', 'The average price field must be a number. (and 1 more error)')
            ->assertJsonPath('errors.average_price.0', 'The average price field must be a number.')
            ->assertJsonPath('errors.average_price.1', 'The average price field must be at least 100000.');
    }

    /**
     * API Create model error when brand not found
     */
    public function test_api_create_model_brand_not_found_response(): void
    {
        $response = $this->postJson("brands/999999/models", [
            'name' => 'Kia Seltos 2024 SX',
            'average_price' => fake()->numberBetween(100000, 9999999)
        ]);

        $response->assertStatus(404)
            ->assertJsonPath('message', 'Vehicle brand not found.');
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

        $brand = $response->json('id');

        $response = $this->postJson("brands/$brand/models", [
            'name' => 'Kia Seltos 2024 SX',
            'average_price' => fake()->numberBetween(100000, 9999999)
        ]);

        $response->assertStatus(201)->assertJsonPath('name', 'Kia Seltos 2024 SX');

        $response = $this->postJson("brands/$brand/models", [
            'name' => 'Kia Seltos 2024 SX',
            'average_price' => fake()->numberBetween(1, 9999999)
        ]);

        $response->assertStatus(422)->assertJsonPath('message', 'The name has already been taken.');
    }

    /**
     * API model resource display all the collection
     */
    public function test_api_model_collection_successful_response(): void
    {
        $response = $this->postJson('/brands', [
            'name' => 'KIA'
        ]);

        $response->assertStatus(201);

        $brand = $response->json('id');

        $this->postJson("brands/$brand/models", [
            'name' => 'Kia Seltos 2024 SX',
            'average_price' => fake()->numberBetween(100000, 9999999)
        ]);

        $response->assertStatus(201);

        $response = $this->postJson("brands/$brand/models", [
            'name' => 'Kia Sportage 2025 SX',
            'average_price' => fake()->numberBetween(100000, 9999999)
        ]);

        $response->assertStatus(201);

        $response = $this->getJson('/models');

        $response->assertStatus(200);

        $response
            ->assertJson(fn (AssertableJson $json) =>
                $json->has(2)->each(fn (AssertableJson $json) =>
                    $json->hasAll([ 'id', 'name', 'average_price'])
                )
            );
    }

    /**
     *  Display error when model not found
     */
    public function test_api_model_put_not_found_response(): void
    {

        $response = $this->patchJson("models/9999999", [
            'average_price' => fake()->numberBetween(100000, 9999999)
        ]);

        $response->assertStatus(404)->assertJsonPath('message', 'Vehicle model not found.');
    }

    /**
     * Model put
     */
    public function test_api_model_put_successful_response(): void
    {
        $response = $this->postJson('/brands', [
            'name' => 'KIA'
        ]);

        $response->assertStatus(201);

        $brand = $response->json('id');

        $this->postJson("brands/$brand/models", [
            'name' => 'Kia Seltos 2024 SX',
            'average_price' => fake()->numberBetween(1, 9999999)
        ]);

        $response->assertStatus(201);

        $response = $this->postJson("brands/$brand/models", [
            'name' => 'Kia Sportage 2025 SX',
            'average_price' => fake()->numberBetween(100000, 9999999)
        ]);

        $response->assertStatus(201);

        $modelId = $response->json('id');

        $avg = fake()->numberBetween(100000, 9999999);

        $response = $this->patchJson("models/$modelId", [
            'average_price' => $avg
        ]);

        $response->assertStatus(200)->assertJsonPath('average_price', $avg);
    }

    /**
     * Model filters
     */
    public function test_api_model_filters_successful_response(): void
    {
        $response = $this->postJson('/brands', [
            'name' => 'KIA'
        ]);

        $response->assertStatus(201);

        $brand = $response->json('id');

        $valueOne = fake()->numberBetween(100000, 200000);
        $this->postJson("brands/$brand/models", [
            'name' => 'Kia Seltos 2024 SX',
            'average_price' => $valueOne
        ]);
        $response->assertStatus(201);

        $valueTwo = fake()->numberBetween(300000, 400000);
        $response = $this->postJson("brands/$brand/models", [
            'name' => 'Kia Sportage 2025 SX',
            'average_price' => $valueTwo
        ]);
        $response->assertStatus(201);

        $response = $this->getJson('/models', [
            'greater' => $valueOne,
            'lower' => $valueTwo
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                    $json->has(2)->each(fn (AssertableJson $json) =>
                    $json->hasAll([ 'id', 'name', 'average_price'])
                )
            );
    }
}
