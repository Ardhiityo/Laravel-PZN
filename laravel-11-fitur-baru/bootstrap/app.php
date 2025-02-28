<?php

use App\Exceptions\ValidationException;
use Illuminate\Support\Facades\Log;
use App\Http\Middleware\LogMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(LogMiddleware::class);
        // $middleware->appendToGroup('web', LogMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //tdk akan mereport jika terjadi exception berikut
        $exceptions->dontReport(ValidationException::class);

        $exceptions->renderable(function (ValidationException $exception, Request $request) {
            return response('Terjadi kesalahan: ' . $exception->getMessage(), 400);
        });

        // $exceptions->reportable(function (Exception $exception) {
        //     Log::info('Terjadi kesalahan: ' . $exception->getMessage());
        //     return false;
        // });

        // //kode dibawah tdk akan dieksekusi apabila return false pada reportable sebelumnya
        $exceptions->reportable(function (Exception $exception) {
            Log::info('Terjadi kesalahan ke 2: ' . $exception->getMessage());
        });
    })->create();
