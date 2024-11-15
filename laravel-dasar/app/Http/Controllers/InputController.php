<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InputController extends Controller
{
    public function hello(Request $request): string
    {
        // Input akan mengecek apakah ada data yang dikirimkan atau tidak, mulai dari get, hingga post
        return $request->input('name');
    }

    public function helloFirstName(Request $request): string
    {
        $firstName = $request->input('name.first');

        return "Hello $firstName";
    }

    public function helloInputAll(Request $request): string
    {
        // Akan mengambil semua data baik itu get, post, dll
        $firstName = $request->input();
        return json_encode($firstName);
    }

    public function helloInputArray(Request $request): string
    {
        // akan mengambil semua data yang ada di dalam array pada products dengan key name 
        $firstName = $request->input("products.*.name");;
        return json_encode($firstName);
    }

    public function query(Request $request)
    {
        // Untuk  mengambil data query parameter dengan semua data
        // return $request->query();

        // Untuk  mengambil data query parameter dengan key name
        return $request->query('name');
    }

    public function inputType(Request $request)
    {
        $name = $request->input('name');
        $married = $request->boolean('married');
        $birthDate = $request->date('birth_date', 'Y-m-d');

        return json_encode([
            'name' => $name,
            'married' => $married,
            'birth_date' => $birthDate->format('Y-m-d')
        ]);
    }

    public function filterOnly(Request $request)
    {
        $request = $request->only(['name.first', 'name.last']);

        return  json_encode($request);
    }

    public function filterExcept(Request $request)
    {
        $request = $request->except(['name.admin']);
        return json_encode($request);
    }

    public function filterMerge(Request $request)
    {
        // merge akan menimpa key yang ada pada request jika ada key yang sama, jika tidak ada key yang sama, maka akan ditambahkan
        $request = $request->merge(['admin' => 'false']);
        return json_encode($request->input());
    }

    public function filterMergeIfMissing(Request $request)
    {
        // mergeIfMissing akan menambahkan key pada request jika tidak ada key yang sama, jika ada key yang sama, maka tidak akan ditambahkan
        $request = $request->mergeIfMissing(['admin' => 'true']);
        return json_encode($request->input());
    }
}
