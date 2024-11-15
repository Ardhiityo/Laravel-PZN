<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CookieController extends Controller
{
    public function createCookie()
    {
        return response('Hello World')
            ->cookie(
                'name',
                'pzn',
                120,
                '/',
            );
    }

    public function getCookie(Request $request)
    {
        return response()->json([
            'name' => $request->cookie('name', 'guest'),
        ]);
    }

    public function clearCookie(Request $request)
    {
        return response('Clear Cookie')
            ->withoutCookie('name');
    }
}
