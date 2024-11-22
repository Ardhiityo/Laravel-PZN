<?php

namespace App\Service\Implementation;

use App\Service\Service;
use App\Service\UserService;

class UserServiceImplementation implements UserService
{
    public array $data = [
        "admin" => "admin",
    ];

    public function login(string $username, string $password): bool
    {
        if (!isset($this->data[$username])) {
            return false;
        }
        $corectPassword = $this->data[$username];
        return $password === $corectPassword;
    }
}
