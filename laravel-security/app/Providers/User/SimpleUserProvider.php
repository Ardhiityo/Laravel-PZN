<?php

namespace App\Providers\User;

use Illuminate\Auth\GenericUser;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;

class SimpleUserProvider implements UserProvider
{
    protected GenericUser $user;

    public function __construct()
    {
        $this->user = new GenericUser([
            "name" => "eko",
            "token" => "secret"
        ]);
    }

    public function retrieveById($identifier) {}

    public function retrieveByToken($identifier, $token) {}

    public function updateRememberToken(Authenticatable $user, $token) {}

    public function retrieveByCredentials(array $credentials)
    {
        $token = $this->user->__get("token") == $credentials["token"];

        if ($token) {
            return $this->user;
        }
        return null;
    }

    public function validateCredentials(Authenticatable $user, array $credentials) {}
}
