<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Service\UserService;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
        $this->seed([UserSeeder::class]);
        $this->assertTrue($this->userService
            ->login("test@gmail.com", "test"));
    }

    public function testLoginFailed()
    {
        $this->seed([UserSeeder::class]);
        $this->assertFalse($this->userService->login("user", "admin"));
    }

    public function testLoginPasswordWrong()
    {
        $this->seed([UserSeeder::class]);
        $this->assertFalse($this->userService->login("test@gmail.com", "user"));
    }
}
