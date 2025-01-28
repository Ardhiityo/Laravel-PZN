<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $login = Auth::attempt([
            "email" => $request->query("email", "wrong"),
            "password" => $request->query("password", "wrong")
        ]);

        if ($login) {
            //akan membuat data user tersimpan di session
            $request->session()->regenerate();
            return redirect('/users/current');

            //akan menghapus session
            // $request->session()->invalidate();
        } else {
            return "Wrong credentials";
        }
    }

    public function current(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            return "Hello $user->name";
        } else {
            return "Hello guest";
        }
    }
}
