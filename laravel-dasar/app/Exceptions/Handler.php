<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Http\Request;
use App\Exceptions\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        // Jika terjadi validation exception, maka exception ini yg akan dieksekusi
        ValidationException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            // var_dump($e);
            echo "Error <br>";

            // Jika true maka reportable dibawahnya akan dieksekusi, jika false maka cukup berhenti disini
            return false;
        });

        // $this->reportable(function (Throwable $e) {
        //     var_dump($e);
        // });

        $this->renderable(function (ValidationException $validationException, Request $request) {
            return response('Bad request', 401);
        });
    }
}
