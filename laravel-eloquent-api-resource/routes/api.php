<?php

use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductDebugResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("/categories/{id}", function ($id) {
    $category = Category::find($id);
    $resource = new CategoryResource($category);
    return $resource;
});

Route::get("/categories", function () {
    $category = Category::all();
    return CategoryResource::collection($category);
});

Route::get("/categories-custom", function () {
    $category = Category::all();
    return new CategoryCollection($category);
});

Route::get("/products", function () {
    $product = Product::query()->with("category")->get();
    return (new ProductCollection($product));
});

Route::get("/products/{id}", function ($id) {
    $product = Product::find($id);
    $product->load("category");
    return (new ProductResource($product))->response()->header("X-POWERED-BY", "PZN");
});

Route::get("/products-paginate", function (Request $request) {
    $page = $request->get("page", 1);
    $product = Product::paginate(perPage: 2, page: $page);
    return new ProductCollection($product);
});

Route::get("/product-debug/{id}", function ($id) {
    $product = Product::find($id);
    return new ProductDebugResource($product);
});
