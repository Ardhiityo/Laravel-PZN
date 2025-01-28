<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function create(Request $request)
    {
        $this->authorize(ability: "create", arguments: Todo::class);

        return response()->json([
            "message" => "success"
        ]);
    }
}
