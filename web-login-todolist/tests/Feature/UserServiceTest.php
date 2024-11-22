<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Service\UserService;

class UserServiceTest extends TestCase
{
    public UserService $userService;

    public function setUp(): void
    {
        parent::setUp();

        $this->userService = $this->app->make(UserService::class);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLoginSuccess()
    {
        $this->assertTrue($this->userService->login("admin", "admin"));
    }

    public function testLoginFailed()
    {
        $this->assertFalse($this->userService->login("user", "admin"));
    }

    public function testLoginPasswordWrong()
    {
        $this->assertFalse($this->userService->login("admin", "user"));
    }
}
