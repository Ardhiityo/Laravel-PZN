<?php

namespace Tests\Feature;

use App\Service\UserService;
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
        $this->post('/login', [
            "user" => "admin",
            "password" => "admin"
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
            "admin" => "admin"
        ])->post('/logout')->assertSessionMissing("user");
    }
    public function testSessionSuccess()
    {
        $this->withSession([
            "admin" => "admin"
        ])->get('/login')->assertRedirect("/");
    }
    public function testSessionSuccessLogin()
    {
        $this->post('/login', [
            "user" => "admin",
            "password" => "admin"
        ])->assertRedirect("/")->assertSessionHas("admin", "admin");
    }
    public function testSessionLogout()
    {
        $this->post('/logout')->assertRedirect("/login");
    }
}
