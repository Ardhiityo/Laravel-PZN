<?php

namespace Tests\Feature;

use App\Models\Tag;
use Tests\TestCase;
use App\Models\Comment;
use App\Models\Products;
use App\Models\Customers;
use Database\Seeders\TagSeeder;
use Database\Seeders\ImageSeeder;
use Database\Seeders\CommentSeeder;
use Database\Seeders\VoucherSeeder;
use Illuminate\Support\Facades\Log;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductsSeeder;
use Database\Seeders\CustomersSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PhpParser\PrettyPrinter;

class ProductTest extends TestCase
{
    public function testOneToMany()
    {
        $this->seed([CategorySeeder::class, ProductsSeeder::class]);

        $product = Products::find("p001");
        self::assertNotNull($product);

        $category = $product->categories;
        self::assertNotNull($category);

        self::assertEquals("c001", $category->id);
        Log::info($category);
    }

    public function testManyToManyInsert()
    {
        $this->seed([CategorySeeder::class, ProductsSeeder::class, CustomersSeeder::class]);

        $product = Products::find("p001");
        $product->likesProducts()->attach("c001");

        $result = $product->likesProducts;

        self::assertCount(1, $result);

        Log::info($result);
    }

    public function testManyToManyDelete()
    {
        $this->testManyToManyInsert();

        $product = Products::find("p001");
        $product->likesProducts()->detach("c001");

        $result = $product->likesProducts;

        self::assertCount(0, $result);

        Log::Info($result);
    }

    public function testPivot()
    {
        $this->seed([CategorySeeder::class, ProductsSeeder::class, CustomersSeeder::class]);

        $product = Products::find("p001");
        self::assertNotNull($product);
        Log::info($product);

        $products = $product->likesProducts;

        foreach ($products as $product) {
            $pivot = $product->pivot;
            self::assertNotNull($pivot->customer_id);
            self::assertNotNull($pivot->product_id);
            self::assertNotNull($pivot->created_at);
        }
    }

    public function testOneToOnePolymorphyc()
    {
        $this->seed([CategorySeeder::class, ProductsSeeder::class, ImageSeeder::class]);

        $product = Products::find("p001");
        $image = $product->images;

        self::assertEquals("p001", $image->imageable_id);
        self::assertEquals("www.pzn.com/images/1", $image->url);

        Log::info($image);
    }

    public function testOneToManyPolymorphic()
    {
        $this->seed([CategorySeeder::class, ProductsSeeder::class, CommentSeeder::class]);

        $product = Products::find("p001");
        $comment = $product->comments;

        self::assertCount(2, $comment);

        self::assertCount(2, $comment);

        Log::info($comment);
    }

    public function testOneToManyPolymorphicWithCondition()
    {
        $this->seed([CategorySeeder::class, ProductsSeeder::class, CommentSeeder::class]);

        $product = Products::find("p001");
        $comment = $product->commentsLatest;

        self::assertNotNull($comment);

        Log::info($comment);
    }

    public function testManyToManyPolymorphic()
    {
        $this->seed([CategorySeeder::class, ProductsSeeder::class, VoucherSeeder::class, TagSeeder::class]);

        $product = Products::find("p001");
        self::assertNotNull($product);

        $tags = $product->tags;
        self::assertCount(1, $tags);
        Log::info($tags);

        foreach ($tags as $tag) {
            self::assertNotNull($tag->id);
            self::assertNotNull($tag->name);

            $voucher = $tag->vouchers;
            self::assertCount(1, $voucher);

            $product = $tag->products;
            self::assertCount(1, $product);

            Log::info($tag);
        }
    }

    public function testEloquentCollection()
    {
        $this->seed([CategorySeeder::class, ProductsSeeder::class]);

        $product = Products::query()->get();

        $query = $product->toQuery()->where("price", 20000)->get();

        self::assertNotNull($query);

        self::assertEquals("p002", $query[0]->id);

        Log::info($query);
    }

    public function testSerialization()
    {
        $this->seed([CategorySeeder::class, ProductsSeeder::class, ImageSeeder::class]);

        $product = Products::query()->get();
        self::assertNotNull($product);

        $toJson = $product->toJson(JSON_PRETTY_PRINT);

        Log::info($toJson);
    }

    public function testSerializationWithLoad()
    {
        $this->seed([CategorySeeder::class, ProductsSeeder::class, ImageSeeder::class]);

        $product = Products::query()->get();
        $product->load(["categories", "images"]);
        self::assertNotNull($product);

        $toJson = $product->toJson(JSON_PRETTY_PRINT);

        Log::info($toJson);
    }
}
