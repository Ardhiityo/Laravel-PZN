<?php

namespace App\Service;

interface UserService
{
    public function login(string $username, string $password): bool;
}
