<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\ApiAuthMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/users', [UserController::class, "register"]);
Route::post('/users/login', [UserController::class, "login"]);

Route::middleware([ApiAuthMiddleware::class])->group(function () {
    Route::get("/users/current", [UserController::class, "get"]);
    Route::delete("/users/logout", [UserController::class, "logout"]);
    Route::patch("/users/current", [UserController::class, "update"]);

    Route::post("/contacts", [ContactController::class, "create"]);
    Route::get("/contacts", [ContactController::class, "search"]);
    Route::get("/contacts/{id}", [ContactController::class, "get"])->where("id", '[0-9]+');
    Route::put("/contacts/{id}", [ContactController::class, "update"])->where("id", '[0-9]+');
    Route::delete("/contacts/{id}", [ContactController::class, "delete"])->where("id", '[0-9]+');

    Route::post("/contacts/{idContacts}/addresses", [AddressController::class, "create"])->where("idContacts", "[0-9]+");
    Route::get("/contacts/{idContacts}/addresses", [AddressController::class, "list"])->where("idContacts", "[0-9]+");
    Route::get("/contacts/{idContacts}/addresses/{idAddresses}", [AddressController::class, "get"])->where("idContacts", "[0-9]+")->where("idAddresses", "[0-9]+");
    Route::put("/contacts/{idContacts}/addresses/{idAddresses}", [AddressController::class, "update"])->where("idContacts", "[0-9]+")->where("idAddresses", "[0-9]+");
    Route::delete("/contacts/{idContacts}/addresses/{idAddresses}", [AddressController::class, "delete"])->where("idContacts", "[0-9]+")->where("idAddresses", "[0-9]+");
});
