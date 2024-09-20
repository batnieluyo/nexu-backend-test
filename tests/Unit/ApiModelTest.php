<?php
namespace Tests\Unit;

use Tests\TestCase;

class ApiModelTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_api_model_successful_response(): void
    {
        $response = $this->get('/models');

        $response->assertStatus(200);
    }
}
