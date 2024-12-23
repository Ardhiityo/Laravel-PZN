<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use Database\Seeders\ProductSeeder;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    public function testProduct()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $product = Product::first();

        self::assertNotNull($product);

        $this->get("/api/products/$product->id")->assertStatus(200)
            ->assertJson([
                "values" => [
                    "id" => $product->id,
                    "name" => $product->name,
                    "category" => [
                        "id" => $product->category->id,
                        "name" => $product->category->name
                    ],
                    "price" => $product->price,
                    "is_expensive" => $product->price > 150
                ]
            ])->assertHeader("X-POWERED-BY", "PZN");
    }

    public function testWrapCollection()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $result = $this->get("/api/products")->assertStatus(200);

        $name = $result->json("data.*.name");

        for ($i = 0; $i < 5; $i++) {
            self::assertContains("product $i of category 1", $name);
            self::assertContains("product $i of category 2", $name);
        }
    }

    public function testPagination()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $result = $this->get("/api/products-paginate")->assertStatus(200);

        self::assertNotNull($result->json("links"));
        self::assertNotNull($result->json("meta"));
        self::assertNotNull($result->json("data"));
    }

    public function testProductAdditional()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $product = Product::first();

        $this->get("/api/product-debug/$product->id")
            ->assertStatus(200)
            ->assertJson([
                "data" => [
                    "id" => $product->id,
                    "name" => $product->name,
                    "category_id" => [
                        "id" => $product->category->id,
                        "name" => $product->category->name
                    ],
                    "price" => $product->price
                ],
                "author" => "Eko Kurniawan Khannedy"
            ]);
    }
    public function testProductAdditionalDynamic()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $product = Product::first();

        $response = $this->get("/api/product-debug/$product->id")
            ->assertStatus(200)
            ->assertJson([
                "data" => [
                    "id" => $product->id,
                    "name" => $product->name,
                    "category_id" => [
                        "id" => $product->category->id,
                        "name" => $product->category->name
                    ],
                    "price" => $product->price
                ],
                "author" => "Eko Kurniawan Khannedy"
            ]);

        self::assertNotNull($response->json("server_time"));
    }
}
