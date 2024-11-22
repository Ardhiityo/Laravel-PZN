<?php


namespace App\Service\Implementation;

use App\Service\TodolistService;
use Illuminate\Support\Facades\Session;

class TodolistServiceImplementation implements TodolistService
{
    public function addTodo(string $id, string $todo)
    {
        if (!Session::exists('todolist')) {
            Session::put('todolist', []);
        }
        Session::push('todolist', [
            'id' => $id,
            'todo' => $todo
        ]);
    }

    public function getTodo(): array
    {
        return Session::get('todolist', []);
    }
    public function removeTodo(string $todoId)
    {
        $todo = Session::get('todolist');

        foreach ($todo as $index => $value) {
            if ($value['id'] == $todoId) {
                unset($todo[$index]);
                break;
            }
        }

        Session::put('todolist', $todo);
    }
};
