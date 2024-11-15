<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function fileUpload(Request $request): string
    {
        // Jika ingin mengambil semua file
        // $request->allFiles();

        // Jika ingin mengambil file berdasarkan key
        $file = $request->file("picture");

        $file->storePubliclyAs("pictures", $file->getClientOriginalName(), "public");

        return "OK " . $file->getClientOriginalName();
    }
}
