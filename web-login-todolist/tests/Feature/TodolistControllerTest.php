<?php

namespace Tests\Feature;

use App\Service\TodolistService;
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
        $this->withSession(["admin" => "admin"])
            ->get('/')->assertSeeText("Todolist")->assertSeeText("Add Todo");
    }

    public function testTodolistWithTodo()
    {
        $this->withSession([
            "admin" => "admin",
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
            ->get('/')
            ->assertSeeText("1")
            ->assertSeeText("Belajar Laravel")
            ->assertSeeText("2")
            ->assertSeeText("Belajar PHP");
    }

    public function testAddTodoFailed()
    {
        $this->withSession(["admin" => "admin"])
            ->post('/todolist', [])
            ->assertSeeText("Todo is required");
    }

    public function testAddTodoSuccess()
    {
        $this->withSession(["admin" => "admin"])
            ->post('/todolist', [
                "todo" => "Belajar Laravel"
            ])
            ->assertRedirect("/");
    }

    public function testRemoveTodolist()
    {
        $this->withSession([
            "admin" => "admin",
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
