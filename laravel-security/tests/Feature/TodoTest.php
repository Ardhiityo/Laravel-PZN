<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Todo;
use App\Models\User;
use Database\Seeders\TodoSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\Auth;

class TodoTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $this->seed([UserSeeder::class, TodoSeeder::class]);

        $this->post("/api/todo")->assertStatus(403);


        $user = User::where("email", "pzn@test")->first();
        $this
            ->actingAs($user)
            ->post("/api/todo")
            ->assertStatus(200)
            ->assertJson(["message" => "success"]);
    }

    public function testView()
    {
        $this->seed([UserSeeder::class, TodoSeeder::class]);

        $user = User::first();
        Auth::login($user);

        $todos = Todo::all();
        $this->view("todos", [
            "todos" => $todos
        ])
            ->assertSeeText("Update")
            ->assertSeeText("Delete")
            ->assertDontSeeText("No Update")
            ->assertDontSeeText("No Delete");
    }

    public function testViewGuest()
    {
        $this->seed([UserSeeder::class, TodoSeeder::class]);

        $todos = Todo::all();
        $this->view("todos", [
            "todos" => $todos
        ])
            ->assertSeeText("No Update")
            ->assertSeeText("No Delete");
    }
}
