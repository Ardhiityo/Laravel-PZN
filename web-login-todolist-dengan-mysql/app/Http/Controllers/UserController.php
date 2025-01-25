<?php

namespace App\Http\Controllers;

use App\Service\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private UserService $userService) {}

    public function login()
    {
        return response()->view("user.login", [
            "title" => "Login"
        ]);
    }
    public function doLogin(Request $request)
    {
        $user = $request->input("user");
        $password = $request->input("password");

        if (empty($user) || empty($password)) {
            return response()->view("user.login", [
                "title" => "Login",
                "error" => "User or password is required"
            ]);
        }

        if ($this->userService->login($user, $password)) {
            $request->session()->put("admin", $user);
            return redirect("/");
        } else {
            return response()->view("user.login", [
                "title" => "Login",
                "error" => "User or password is wrong"
            ]);
        }
    }
    public function logout(Request $request)
    {
        $request->session()->forget("admin");
        return redirect("/");
    }
}
