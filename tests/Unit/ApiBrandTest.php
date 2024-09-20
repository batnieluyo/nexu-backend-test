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
     * Create brand
     */
    public function test_api_create_2_brand_successful_response(): void
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
}
