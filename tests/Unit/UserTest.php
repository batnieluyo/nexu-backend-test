<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    function test_user()
    {
        $user = User::factory()->create();

        $this->assertDatabaseCount('users', 1);

        $this->assertDatabaseHas('users', [
            'email' => $user->email,
        ]);
    }
}
