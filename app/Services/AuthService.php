<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Try attemp a user session and return a valid tokens sessions
     *
     ** @param array<string, string> $credentials
     ** @return array{token: string, user: \App\Models\User} | false
     */
    public function login(array $credentials): User|false
    {
        try {
            if (Auth::attempt($credentials)) {
                return Auth::user();
            }

            return false;
        } catch (\Throwable $e) {
            Log::error('Error on login attempt: '.$e->getMessage(), [
                'email' => $credentials['email'] ?? 'not_provided',
            ]);

            return false;
        }
    }

    /**
     * Regiser a User in DB
     *
     ** @param array<string, string> $data
     *
     * @throws Exception
     */
    public function register(array $data): User
    {
        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            Log::info('User created: '.$user->id);

            return $user;
        } catch (Exception $e) {
            Log::error('Error on register User: '.$e->getMessage());
            throw new Exception('Erron on create User: '.$e->getMessage());
        }
    }
}
