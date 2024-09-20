<?php
namespace Tests\Unit;

use Tests\TestCase;

class ApiBrandTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_api_brand_successful_response(): void
    {
        $response = $this->get('/brands');

        $response->assertStatus(200);
    }
}
