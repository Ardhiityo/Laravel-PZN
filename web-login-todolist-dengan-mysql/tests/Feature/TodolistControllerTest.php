<?php

namespace Tests\Feature;

use App\Service\TodolistService;
use Database\Seeders\TodoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{

    public TodolistService $todolistService;

    public function setUp(): void
    {
        parent::setUp();
        $this->todolistService = $this->app->make(TodolistService::class);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testTodolist()
    {
        $this->withSession(["admin" => "test@gmail.com"])
            ->get('/')->assertSeeText("Todolist")->assertSeeText("Add Todo");
    }

    public function testTodolistWithTodo()
    {
        $this->seed([TodoSeeder::class]);

        $this->withSession([
            "admin" => "test@gmail.com",
        ])
            ->get('/')
            ->assertSeeText("1")
            ->assertSeeText("Belajar Laravel")
            ->assertSeeText("2")
            ->assertSeeText("Belajar PHP");
    }

    public function testAddTodoFailed()
    {
        $this->withSession(["admin" => "test@gmail.com"])
            ->post('/todolist', [])
            ->assertSeeText("Todo is required");
    }

    public function testAddTodoSuccess()
    {
        $this->withSession(["admin" => "test@gmail.com"])
            ->post('/todolist', [
                "todo" => "Belajar Laravel"
            ])
            ->assertRedirect("/");
    }

    public function testRemoveTodolist()
    {
        $this->withSession([
            "admin" => "test@gmail.com",
            "todolist" => [
                [
                    "id" => "1",
                    "todo" => "Belajar Laravel"
                ],
                [
                    "id" => "2",
                    "todo" => "Belajar PHP"
                ]
            ]
        ])
            ->post('/todolist/1/delete')
            ->assertRedirect("/");
    }
}
