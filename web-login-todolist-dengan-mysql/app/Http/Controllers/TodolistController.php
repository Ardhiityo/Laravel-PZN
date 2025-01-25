<?php

namespace App\Http\Controllers;

use App\Service\TodolistService;
use Illuminate\Http\Request;


class TodolistController extends Controller
{
    public function __construct(public TodolistService $todolistService) {}

    public function todoList(Request $request)
    {
        $todolist = $this->todolistService->getTodo();
        return response()->view('todolist.todolist', [
            'title' => 'Todolist',
            'todolist' => $todolist
        ]);
    }

    public function addTodo(Request $request)
    {
        $todo = $request->input('todo');

        if (empty($todo)) {
            $todolist = $this->todolistService->getTodo();
            return response()->view('todolist.todolist', [
                'title' => 'Todolist',
                'todolist' => $todolist,
                'error' => 'Todo is required'
            ]);
        }

        $this->todolistService->addTodo(uniqid(), $todo);
        return redirect()->action([TodolistController::class, 'todoList']);
    }
    public function removeTodo(Request $request, string $todoId)
    {
        $this->todolistService->removeTodo($todoId);
        return redirect()->action([TodolistController::class, 'todoList']);
    }
}
