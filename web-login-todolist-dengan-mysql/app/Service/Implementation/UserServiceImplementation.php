<?php

namespace App\Service\Implementation;

use App\Service\UserService;
use Illuminate\Support\Facades\Auth;

class UserServiceImplementation implements UserService
{
    public function login(string $email, string $password): bool
    {
        return Auth::attempt([
            "email" => $email,
            "password" => $password
        ]);
    }
}
