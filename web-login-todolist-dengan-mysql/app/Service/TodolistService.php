<?php

namespace App\Service;

interface TodolistService
{
    public function addTodo(string $id, string $todo);
    public function getTodo(): array;
    public function removeTodo(string $todoId);
};
