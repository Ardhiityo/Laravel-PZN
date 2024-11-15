<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormController extends Controller
{
    public function form()
    {
        return view('form');
    }

    public function submit(Request $request)
    {
        $name = $request->input('name');

        return "Hello $name";
    }
}
