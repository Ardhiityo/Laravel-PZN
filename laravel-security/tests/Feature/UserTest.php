<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Todo;
use App\Models\User;
use Database\Seeders\TodoSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserTest extends TestCase
{
    public function testAuth()
    {
        $this->seed([UserSeeder::class]);

        $login = Auth::attempt([
            "email" => "pzn@test",
            "password" => "test"
        ], remember: true);

        self::assertTrue($login);

        $user = Auth::user();

        self::assertNotNull($user->email);
    }

    public function testAuthEmpty()
    {
        $login = Auth::user();

        self::assertNull($login);
    }

    public function testLogin()
    {
        $this->seed(UserSeeder::class);

        $this->get("/users/login?email=pzn@test&password=test")
            ->assertRedirect("/users/current");

        $this->get("/users/login?email=pzn@test&password=salah")->assertSeeText("Wrong credentials");
    }

    public function testCurrent()
    {
        $this->seed(UserSeeder::class);

        //jika belum login akan di redirect
        $this->get("/users/current")->assertStatus(302);

        //sudah login
        $user = User::first();
        //acting as akan membuat user terdaftar di session
        $this->actingAs($user)
            ->get("/users/current")->assertSeeText("Hello pzn");
    }

    public function testGuestRegis()
    {
        $this->seed([UserSeeder::class]);

        self::assertTrue(Gate::allows("create", User::class));
    }

    public function testGuestRegisOnUser()
    {
        $this->seed([UserSeeder::class]);

        $user = User::first();

        Auth::login($user);
        self::assertFalse(Gate::allows("create", User::class));
    }

    public function testBefore()
    {
        $this->seed([UserSeeder::class, TodoSeeder::class]);

        $user = User::create([
            "name" => "superadmin",
            "email" => "admin@test",
            "password" => Hash::make("rahasia"),
        ]);

        Auth::login($user);

        $todo = Todo::first();

        self::assertTrue($user->can("delete", $todo));
    }
}
