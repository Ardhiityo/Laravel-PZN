<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Service\TodolistService;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TodolistServiceTest extends TestCase
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
    public function testTodolistServiceProvider()
    {
        self::assertNotNull($this->todolistService);
    }

    public function testAddTodo()
    {
        $this->todolistService->addTodo("1", "Belajar Laravel");

        $session = Session::get('todolist');

        foreach ($session as $value) {
            self::assertEquals("1", $value['id']);
            self::assertEquals("Belajar Laravel", $value['todo']);
        }
    }

    public function testGetTodoEmpty()
    {
        self::assertEquals([], $this->todolistService->getTodo());
    }

    public function testGetTodoNotEmpty()
    {
        $this->todolistService->addTodo("1", "Belajar Laravel");
        $this->todolistService->addTodo("2", "Belajar PHP");

        $expected = [
            [
                "id" => "1",
                "todo" => "Belajar Laravel"
            ],
            [
                "id" => "2",
                "todo" => "Belajar PHP"
            ]
        ];

        self::assertEquals($expected, $this->todolistService->getTodo());
    }
    public function testRemoveTodo()
    {
        $this->todolistService->addTodo("1", "Belajar Laravel");
        $this->todolistService->addTodo("2", "Belajar PHP");

        self::assertEquals(2, sizeof($this->todolistService->getTodo()));

        $this->todolistService->removeTodo("3");

        self::assertEquals(2, sizeof($this->todolistService->getTodo()));

        $this->todolistService->removeTodo("1");

        self::assertEquals(1, sizeof($this->todolistService->getTodo()));

        $this->todolistService->removeTodo("2");

        self::assertEquals(0, sizeof($this->todolistService->getTodo()));
    }
}
