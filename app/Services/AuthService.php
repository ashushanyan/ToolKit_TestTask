<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    public function register(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'birthdate' => $data['birthdate'],
        ]);
    }

    public function login(string $email, string $password): string
    {
        $credentials = [
            'email' => $email,
            'password' => $password
        ];

        if (!$token = JWTAuth::attempt($credentials)) {
            throw new \Exception('Invalid login credentials');
        }

        return $token;
    }

    public function logout(): void
    {
        Auth::logout();
    }

    public function getUserByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
}
