<?php


namespace App\Service\Implementation;

use App\Models\Todo;
use App\Service\TodolistService;

class TodolistServiceImplementation implements TodolistService
{
    public function addTodo(string $id, string $todo)
    {
        Todo::create([
            "id" => $id,
            "name" => $todo
        ]);
    }

    public function getTodo(): array
    {
        return Todo::all()->toArray();
    }
    public function removeTodo(string $todoId)
    {
        $todo = Todo::find($todoId);
        if ($todo) {
            $todo->delete();
        }
    }
};
