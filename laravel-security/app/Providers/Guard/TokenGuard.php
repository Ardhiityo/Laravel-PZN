<?php

namespace App\Providers\Guard;

use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;

class TokenGuard implements Guard
{
    use GuardHelpers;

    protected Request $request;

    public function __construct(UserProvider $userProvider, Request $request)
    {
        $this->request = $request;
        $this->setProvider($userProvider);
    }

    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    public function user()
    {
        if ($this->user != null) {
            return $this->user;
        }

        $token = $this->request->header("API-Key");

        if ($token) {
            $this->user = $this->provider->retrieveByCredentials(["token" => $token]);
        }

        return $this->user;
    }

    public function validate(array $credentials = [])
    {
        return $this->provider->validateCredentials($this->user, $credentials);
    }
}
