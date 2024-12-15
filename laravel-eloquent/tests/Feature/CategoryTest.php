<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Category;
use App\Models\Products;
use Illuminate\Support\Facades\Log;
use App\Models\Scopes\IsActiveScope;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CustomersSeeder;
use Database\Seeders\ProductsSeeder;
use Database\Seeders\ReviewSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    public function testInsert()
    {
        $category = new Category();
        $category->id = "c001";
        $category->name = "category 1";
        $result = $category->save();

        self::assertTrue($result);
        Log::info($result);
    }

    public function testInsertMany()
    {
        $categories = [];

        for ($i = 1; $i <= 5; $i++) {
            $categories[] = [
                "id" => "c-$i",
                "name" => "title-$i",
                "is_active" => true
            ];
        }

        $result = Category::insert($categories);

        self::assertTrue($result);
        Log::info($result);
    }

    public function testFind()
    {
        $this->seed(CategorySeeder::class);

        $result = Category::find("c001");

        self::assertEquals("c001", $result->id);
        self::assertEquals("category1", $result->name);

        Log::info($result);
    }

    public function testUpdate()
    {
        $this->seed(CategorySeeder::class);

        $result = Category::find("c001");
        $result->name = "category 1 updated";
        $result->update();

        self::assertEquals("category 1 updated", $result->name);
        Log::info($result);
    }

    public function testSelect()
    {
        $this->testInsertMany();

        $categories = Category::query()->whereNull("description")->get();
        self::assertCount(5, $categories);

        foreach ($categories as $category) {
            $category->description = "updated";
            $category->save();
        }

        Log::info($categories);
    }

    public function testUpdateMany()
    {
        $this->testInsertMany();

        Category::query()->whereNull("description")->update(["description" => "updated"]);

        $result = Category::query()->where("description", "updated")->get();

        self::assertCount(5, $result);

        Log::info($result);
    }

    public function testDelete()
    {
        $this->seed(CategorySeeder::class);

        Category::find("c001")->delete();

        $result = Category::query()->get();

        self::assertCount(0, $result);

        Log::info($result);
    }

    public function testDeleteMany()
    {
        $this->testInsertMany();

        Category::whereNull("description")->delete();

        $result = Category::query()->get();

        self::assertCount(0, $result);

        Log::info($result);
    }

    public function testFillable()
    {
        $categories = [
            "id" => "c001",
            "name" => "Eko",
            "description" => "Test"
        ];

        $result = Category::create($categories);

        self::assertEquals("c001", $result->id);

        Log::info($result);
    }

    public function testFill()
    {
        $this->seed(CategorySeeder::class);

        $categories = [
            "id" => "c001",
            "name" => "category updated",
            "description" => "desc updated"
        ];

        $category = Category::find("c001");

        $category->fill($categories);
        $category->save();

        $result = Category::where("name", "category updated")->first();

        self::assertEquals("category updated", $result->name);

        Log::info($result);
    }

    public function testGlobalScope()
    {
        $this->testInsert();

        $result = Category::find("c001");

        self::assertNull($result);

        Log::info($result);

        $category = new Category();
        $category->id = "c002";
        $category->name = "category2";
        $category->is_active = true;
        $category->save();

        $result = Category::find("c002");

        self::assertNotNull($result);
        Log::info($result);
    }

    public function testWithOutGlobalScope()
    {
        $this->testInsert();

        $result = Category::withoutGlobalScope(IsActiveScope::class)->find("c001");

        self::assertNotNull($result);
    }

    public function testOneToMany()
    {
        $this->seed([CategorySeeder::class, ProductsSeeder::class]);

        $category = Category::find("c001");
        self::assertNotNull($category);

        $products = $category->products;
        self::assertNotNull($products);

        self::assertEquals("p001", $products[0]->id);
        Log::info($products);
    }

    public function testOnetoOneQuery()
    {
        $category = new Category();
        $category->id = "c001";
        $category->name = "Category 1";
        $category->save();

        $product = new Products();
        $product->id = "p001";
        $product->name = "product 1";
        $product->description = "product 1 description";
        $product->price = 12000;
        $product->stock = 11;

        $category->products()->save($product);

        self::assertNotNull($product->category_id);

        Log::info($product);
    }

    public function testOneToOneQueryBuilder()
    {
        $this->seed([CategorySeeder::class, ProductsSeeder::class]);

        $category = Category::find("c001");
        $result = $category->products()->where("stock", "<", 5)->get();

        self::assertCount(2, $result);

        Log::info($result);
    }

    public function testHasOneOfMany()
    {
        $this->seed([CategorySeeder::class, ProductsSeeder::class]);

        $category = Category::find("c001");
        $product = $category->cheapestProducts;

        self::assertEquals("p001", $product->id);
        Log::info($product);

        $product = $category->mostExpensiveProducts;
        self::assertEquals("p002", $product->id);
        Log::info($product);
    }

    public function testHasManyThrough()
    {
        $this->seed([CategorySeeder::class, ProductsSeeder::class, CustomersSeeder::class, ReviewSeeder::class]);

        $category = Category::find("c001");
        self::assertNotNull($category);

        $reviews = $category->reviews;
        self::assertCount(2, $reviews);

        Log::info($reviews);
    }

    public function testQueryingRelations()
    {
        $this->seed([CategorySeeder::class, ProductsSeeder::class]);

        $category = Category::find("c001");
        $product = $category->products()->where("price", 20000)->get();

        self::assertCount(1, $product);

        Log::info($product);
    }

    public function testAggregatingRelations()
    {
        $this->seed([CategorySeeder::class, ProductsSeeder::class]);

        $category = Category::find("c001");

        $product = $category->products()->count();
        self::assertEquals(2, $product);

        $product = $category->products()->where("price", 20000)->count();
        self::assertEquals(1, $product);
    }
}
