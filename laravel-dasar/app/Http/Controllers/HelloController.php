<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\HelloService;
use App\Http\Controllers\Controller;

class HelloController extends Controller
{
    public HelloService $helloService;

    public function __construct(HelloService $helloService)
    {
        $this->helloService = $helloService;
    }

    public function hello($name): string
    {
        return $this->helloService->hello($name);
    }

    public function request(Request $request): string
    {
        return $request->path() .
            $request->url() .
            $request->fullUrl() .
            $request->method() .
            $request->header('Accept');
    }
}
