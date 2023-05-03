<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected $useDatabaseTransactions = false;

    /**
     * Test the register endpoint.
     *
     * @return void
     */
    public function testRegister()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'aaAA11',
            'password_confirmation' => 'aaAA11',
            'birthdate' => '1990-01-01',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'user' => [
                    'id',
                    'name',
                    'email',
                    'birthdate',
                    'created_at',
                    'updated_at',
                ],
                'token'
            ]);
    }

    /**
     * Test the login endpoint.
     *
     * @return void
     */
    public function testLogin()
    {
        $user = User::factory()->create([
            'email' => 'johndoe@example.com',
            'password' => bcrypt('aaAA11'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'aaAA11',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'user' => [
                'name',
                'email',
                'birthdate',
                'created_at',
                'updated_at',
                'id',
            ],
            'token',
        ]);
    }
}
