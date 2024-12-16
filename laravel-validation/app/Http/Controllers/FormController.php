<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class FormController extends Controller
{
    public function index(Request $request)
    {
        // $data = [
        //     "username" => $request->input("username"),
        //     "password" => $request->input("password")
        // ];
        // $rules = [
        //     "username" => ["required"],
        //     "password" => ["required"]
        // ];

        // try {
        //     $request->validate($rules, $data);
        //     return response("OK", 200);
        // } catch (ValidationException $validationException) {
        //     return response(json_encode($validationException->errors(), JSON_PRETTY_PRINT), 400);
        // }

        try {
            $request->validate([
                "username" => "required",
                "password" => "required"
            ]);
            return response("OK", 200);
        } catch (ValidationException $validationException) {
            return response($validationException->errors(), 400);
        }
    }

    public function viewForm(Request $request)
    {
        return response()->view("form");
    }

    public function submitForm(LoginRequest $request)
    {
        $data = $request->validated();
        Log::info($request->all());

        return response("OK", 200);
    }
}
