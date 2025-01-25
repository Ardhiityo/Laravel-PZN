<?php

namespace Tests\Feature;

use App\Service\UserService;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    private UserService $userService;
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
    public function testLoginView()
    {
        $this->get('/login')->assertSeeText("Login");
    }
    public function testLoginDoLoginSuccess()
    {
        $this->seed([UserSeeder::class]);

        $this->withSession(["admin" => "test@gmail.com"])
            ->post('/login', [
                "username" => "test@gmail.com",
                "password" => "test"
            ])->assertRedirect("/");
    }
    public function testLoginDoLoginEmpty()
    {
        $this->post('/login', [
            "user" => "",
            "password" => ""
        ])->assertSeeText("User or password is required");
    }
    public function testLoginDoLoginWrongPassword()
    {
        $this->post('/login', [
            "user" => "admin",
            "password" => "user"
        ])->assertSeeText("User or password is wrong");
    }
    public function testLogout()
    {
        $this->withSession([
            "admin" => "test@gmail.com"
        ])->post('/logout')->assertSessionMissing("admin");
    }
    public function testSessionSuccess()
    {
        $this->withSession([
            "admin" => "test@gmail.com"
        ])->get('/login')->assertRedirect("/");
    }
    public function testSessionSuccessLogin()
    {
        $this->seed([UserSeeder::class]);

        $this->post('/login', [
            "user" => "test@gmail.com",
            "password" => "test"
        ])->assertRedirect("/")->assertSessionHas("admin", "test@gmail.com");
    }
    public function testSessionLogout()
    {
        $this->post('/logout')->assertRedirect("/login");
    }
}
