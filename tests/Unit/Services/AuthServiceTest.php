<?php

namespace Tests\Feature\Services;

use App\Models\User;
use App\Services\AuthService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthServiceTest extends TestCase
{
    use RefreshDatabase;

    private AuthService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new AuthService;
    }

    /** @test */
    public function it_returns_user_when_credentials_are_correct(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $credentials = [
            'email' => 'test@example.com',
            'password' => 'password123',
        ];

        $result = $this->service->login($credentials);

        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals($user->id, $result->id);
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function it_returns_null_when_credentials_are_incorrect(): void
    {
        User::factory()->create([
            'email' => 'user@example.com',
            'password' => Hash::make('correct_password'),
        ]);

        $credentials = [
            'email' => 'user@example.com',
            'password' => 'wrong_password',
        ];

        $result = $this->service->login($credentials);

        $this->assertNull($result);
        $this->assertGuest();
    }

    /** @test */
    public function it_registers_a_new_user_successfully(): void
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'secret123',
        ];

        $user = $this->service->register($data);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('John Doe', $user->name);

        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
        ]);

        $this->assertTrue(Hash::check('secret123', $user->password));
    }

    /** @test */
    public function it_throws_exception_on_registration_failure(): void
    {
        User::factory()->create(['email' => 'duplicate@example.com']);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Failed to register user');

        $data = [
            'name' => 'New User',
            'email' => 'duplicate@example.com',
            'password' => 'password123',
        ];

        $this->service->register($data);
    }
}
