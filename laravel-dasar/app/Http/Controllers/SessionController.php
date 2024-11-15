<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function session()
    {
        session()->put('name', 'John');
        session()->put('member', 'true');
        return "OK";
    }

    public function getSession(Request $request)
    {
        $name = $request->session()->get("name", 'guest');
        $member = $request->session()->get("member", 'false');

        return "UserId: $name, Member: $member";
    }
}
