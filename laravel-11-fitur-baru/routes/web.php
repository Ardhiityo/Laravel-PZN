<?php

use App\Exceptions\ValidationException;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/sample/error', function () {
    report('sample error');
    echo 'Sample error';
});

Route::get('/sample/validation', function () {
    throw new ValidationException('sample error');
});

Route::get('/abort/400', function () {
    abort(400, 'Sample error');
});

Route::get('/abort/404', function () {
    abort(404);
});
