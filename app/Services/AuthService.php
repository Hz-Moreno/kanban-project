<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Throwable;

class AuthService
{
    public function login(array $credentials): ?User
    {
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            Log::info('User logged in successfully', ['user_id' => $user->id]);

            return $user;
        }

        return null;
    }

    public function register(array $data): User
    {
        return DB::transaction(function () use ($data) {
            try {
                $user = User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                ]);

                Log::info('User registered successfully', ['user_id' => $user->id]);

                return $user;

            } catch (Throwable $e) {
                Log::error('Failed to register user', [
                    'email' => $data['email'],
                    'error' => $e->getMessage(),
                ]);

                throw new \RuntimeException('Failed to register user');
            }
        });
    }
}
