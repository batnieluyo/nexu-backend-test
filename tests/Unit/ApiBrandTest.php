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

        $response->dump();

        $response->assertStatus(200);

        $response
            ->assertJson(fn (AssertableJson $json) =>
                $json->has(2)->each(fn (AssertableJson $json) =>
                    $json->hasAll([ 'id', 'name', 'average_price'])
                )
            );
    }
}
