<?php

namespace App\Service;

use App\Service\HelloService;

class HelloServiceIndonesia implements HelloService
{
    public function hello(string $name): string
    {
        return "Hello $name";
    }
}
