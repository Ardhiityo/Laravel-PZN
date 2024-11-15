<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ResponseController extends Controller
{
    public function response()
    {
        return response("Hello World");
    }

    public function responseHeader()
    {
        // Cara 1
        // return response(json_encode("Hello World"), 200, ['Content-Type' => 'application/json']);

        // Cara 2
        $content = [
            'name' => 'PZN',
            'age' => 20
        ];
        return response(json_encode($content), 200)->header('Content-Type', 'application/json')
            ->withHeaders([
                'Author' => 'PZN',
                'App' => 'Belajar Laravel'
            ]);
    }

    public function responseView(): Response
    {
        return response()->view('hello', ['name' => 'PZN']);
    }

    public function responseJson(): JsonResponse
    {
        return response()->json(['name' => 'PZN', 'age' => 20]);
    }

    public function responseFile(): BinaryFileResponse
    {
        return response()->file(storage_path('app/public/pictures/pzn.png'));
    }

    public function responseDownload(): BinaryFileResponse
    {
        return response()->download(storage_path('app/public/pictures/pzn.png'));
    }
}
