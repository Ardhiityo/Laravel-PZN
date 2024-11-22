<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TodolistController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\GuestOnlyMiddleware;
use App\Http\Middleware\MemberOnlyMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::controller(UserController::class)->group(function () {
    Route::get('/login', 'login')->name('login')->middleware(GuestOnlyMiddleware::class);
    Route::post('/login', 'doLogin')->name('do-login')->middleware(GuestOnlyMiddleware::class);
    Route::post('/logout', 'logout')->name('logout')->middleware(MemberOnlyMiddleware::class);
});

Route::controller(TodolistController::class)->middleware([MemberOnlyMiddleware::class])->group(function () {
    Route::get('/', 'todoList')->name('todolist');
    Route::post('/todolist', 'addTodo')->name('todolist.add');
    Route::post('/todolist/{todoId}/delete', 'removeTodo')->name('todolist.delete');
});
