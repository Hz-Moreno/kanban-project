<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function login_returns_201_on_success(): void
    {
        $user = User::factory()->create([
            'email' => 'login@test.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/login/create', [
            'email' => 'login@test.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJson([
                'status' => 'success',
                'user' => ['id' => $user->id],
            ]);

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function login_returns_401_for_invalid_credentials(): void
    {
        User::factory()->create([
            'email' => 'correct@test.com',
            'password' => Hash::make('secret'),
        ]);

        $response = $this->postJson('/login/create', [
            'email' => 'correct@test.com',
            'password' => 'wrong_password',
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJson(['status' => 'error']);

        $this->assertGuest();
    }

    /** @test */
    public function register_creates_user_and_returns_201(): void
    {
        $data = [
            'name' => 'New User',
            'email' => 'new@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/register/create', $data);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonPath('status', 'success');

        $this->assertDatabaseHas('users', ['email' => 'new@test.com']);
    }

    /** @test */
    public function register_returns_422_when_validation_fails(): void
    {
        $response = $this->postJson('/register/create', []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name', 'email', 'password']);
    }

    /** @test */
    public function logout_invalidates_session_and_redirects_to_login(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }

    /** @test */
    public function unauthenticated_user_cannot_access_logout_route(): void
    {
        $response = $this->post('/logout');

        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect('/login');
    }
}
