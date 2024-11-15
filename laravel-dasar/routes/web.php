<?php

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FormController;
use App\Http\Middleware\VerifyCsrfToken;
use App\Http\Controllers\HelloController;
use App\Http\Controllers\InputController;
use App\Http\Middleware\ContohMiddleware;
use App\Http\Controllers\CookieController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\ResponseController;
use App\Exceptions\ValidationException;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pzn', function () {
    return "Hello PZN";
});

// Redirect cara 1
// Route::get('/youtube', function () {
//     return redirect('/pzn');
// });

// Redirect cara 2
Route::redirect('/youtube', '/pzn');

// Jika route tidak ditemukan
Route::fallback(function () {
    return "404 by PZN";
});

// Get Cara 1
// Route::view('/hello', 'hello', ['name' => 'PZN']);

// Get Cara 2
Route::get('/hello', function () {
    return view('hello', [
        'name' => 'PZN'
    ]);
});

Route::get('/hello-world', function () {
    return view('hello.world', [
        'name' => 'PZN'
    ]);
});

// Route parameter
Route::get('/products/{id}', function ($productId) {
    return "product $productId";
})->name('product.detail');

Route::get('/products/{id}/items/{item}', function ($productId, $itemId) {
    return "product $productId item $itemId";
})->name('product.item.detail');

// Route parameter regex
Route::get('/categories/{id}', function ($categoryId) {
    return "category $categoryId";
})->where('id', '[0-9]+')->name('category.detail');

// Route parameter optional
Route::get('/users/{id?}', function ($userId = '404') {
    return "user $userId";
})->name('user.detail');

// Contoh penggunaan route parameter dengan named
Route::get('/produk/{id}', function ($productId) {
    $link = route('product.detail', ['id' => $productId]);
    return "Link : $link";
});

Route::get('produk/redirect/{id}', function ($productId) {
    return redirect()->route('product.detail', ['id' => $productId]);
});

Route::get('/controller/hello/request', [HelloController::class, 'request']);

Route::get('/controller/hello/{name}', [HelloController::class, 'hello']);



// Contoller Group
Route::controller(InputController::class)->group(function () {
    Route::get('/input/hello', 'hello');

    Route::post('/input/hello', 'hello');
    Route::post('/input/hello/first', 'helloFirstName');
    Route::post('/input/hello/all', 'helloInputAll');
    Route::post('/input/hello/array', 'helloInputArray');

    // Query Parameter
    Route::get('/input/query', 'query');

    Route::post('/input/type', 'inputType');

    // Request only
    Route::post('/input/filter/only', 'filterOnly');

    // Request except
    Route::post('/input/filter/except', 'filterExcept');

    // Request merge
    Route::post('/input/filter/merge', 'filterMerge');
});



// Reuqest mergeIsMissing
Route::post('/input/filter/merge/ifmissing', [InputController::class, 'filterMergeIfMissing']);

// Request Upload File
Route::post('/file/upload', [FileController::class, 'fileUpload'])->withoutMiddleware(VerifyCsrfToken::class);

Route::get('/response', [ResponseController::class, 'response']);

Route::get('/response/header', [ResponseController::class, 'responseHeader']);



// Group Prefix
Route::prefix('/response')->group(function () {
    Route::get('/view', [ResponseController::class, 'responseView']);

    Route::get('/json', [ResponseController::class, 'responseJson']);

    Route::get('/file', [ResponseController::class, 'responseFile']);

    Route::get('/download', [ResponseController::class, 'responseDownload']);
});



// Response Cookie
Route::get('/cookie', [CookieController::class, 'createCookie']);

// Response GetCookie
Route::get('/cookie/get', [CookieController::class, 'getCookie']);

// Clear Cookie
Route::get('/cookie/clear', [CookieController::class, 'clearCookie']);

// Redirect
Route::get('/redirect', [RedirectController::class, 'redirectFrom']);
Route::get('/redirect/to', [RedirectController::class, 'redirectTo']);

// Redirect Name
Route::get('/redirect/name', [RedirectController::class, 'redirectName']);

Route::get('/redirect/hello/{name}', [RedirectController::class, 'redirectHello'])->name('redirect-hello');

// Redirect Action
Route::get('/redirect/action', [RedirectController::class, 'redirectAction']);

// Redirect Away
Route::get('/redirect/away', [RedirectController::class, 'redirectAway']);



// Middleware Group with Prefix
Route::middleware('contoh:PZN, 401')->prefix('middleware')->group(function () {
    Route::get('/api', function () {
        return "OK";
    });
    Route::get('/group', function () {
        return "GROUP";
    });
});

//** Middleware group tanpa prefix */
// Route::middleware('contoh:PZN, 401')->group(function () {
//     Route::get('/middleware/api', function () {
//         return "OK";
//     });
//     Route::get('/middleware/group', function () {
//         return "GROUP";
//     });
// });

//** Middleware non group */
// Route::get('/middleware', function () {
//     return "OK";
// })->middleware(['contoh:PZN,401']);

// Route::get('/middleware/group', function () {
//     return "GROUP";
// })->middleware(['pzn']);



Route::get('/form', [FormController::class, 'form']);
Route::post('/form', [FormController::class, 'submit']);



// Url Generator
Route::get('/url/current', function () {
    // Bisa menggunakan helper function url
    // return url()->full();

    // Bisa menggunakan Facades
    return URL::full();
});

Route::get('/url/named', function () {
    return route('redirect-hello', ['name' => 'PZN']);
});


Route::get('/url/action', function () {
    // Cara 1
    return action([FormController::class, 'form']);

    // Cara 2
    // return url()->action([FormController::class, 'form']);

    // Cara 3 
    // return URL::action([FormController::class, 'form']);
});


Route::get('/session', [SessionController::class, 'session']);
Route::get('/session/get', [SessionController::class, 'getSession']);


Route::get('/error/sample', function () {
    throw new Exception("Ups");
});
Route::get('/error/manual', function () {
    report(new Exception("Ups"));
    return "OK";
});
Route::get('/error/validation', function () {
    throw new ValidationException("Validation Error");
});


// Abort
Route::get('/abort/400', function () {
    abort(400, "Ups 400");
});
Route::get('/abort/401', function () {
    abort(400, "Ups 401");
});
Route::get('/abort/500', function () {
    abort(400, "Ups 500");
});
