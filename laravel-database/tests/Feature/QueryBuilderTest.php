<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Database\Seeders\CategoriesSeeder;
use Database\Seeders\CountersSeeder;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QueryBuilderTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        DB::delete("DELETE FROM products");
        DB::delete("DELETE FROM categories");
        DB::delete("DELETE FROM counters");
    }

    public function tearDown(): void
    {
        parent::setUp();

        DB::delete("DELETE FROM products");
        DB::delete("DELETE FROM categories");
        DB::delete("DELETE FROM counters");
    }

    public function testInsert()
    {
        DB::table("categories")->insert(["id" => "c001", "name" => "acc", "description" => "accesories"]);

        DB::table("categories")->insert(["id" => "c002", "name" => "acc", "description" => "accesories"]);

        $result = DB::select("SELECT count(id) as total FROM categories");

        self::assertEquals(2, $result[0]->total);
    }

    public function testSelect()
    {
        $this->testInsert();

        $result = DB::table('categories')->select(["id", "name"])->get();

        self::assertNotNull($result);

        $result->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    public function testWhere()
    {
        $this->seed(CategoriesSeeder::class);

        // Use where(column, operator, value)
        // $collection = DB::table('categories')->where("id", "=", "c001")->get();
        // self::assertCount(1, $collection);


        // // Use where([condition1, condition2])
        // $collection = DB::table('categories')
        //     ->where([
        //         ['id', '=', 'c001'],
        //         ['name', '=', 'gadget']
        //     ])
        //     ->get();
        // self::assertCount(1, $collection);


        // // Use where(callback(Builder))
        // $collection = DB::table('categories')->where(function (Builder $builder) {
        //     $builder->where('id', '=', 'c001')
        //         ->orWhere('id', '=', 'c002');
        // })->get();
        // self::assertCount(2, $collection);


        // // orWhere(column, operator, value)
        // $collection = DB::table("categories")->orWhere("id", "=", "c001")->get();
        // self::assertCount(1, $collection);


        // // orWhere(callback(Builder))
        // $collection = DB::table("categories")->orWhere(function (Builder $builder) {
        //     $builder->where("id", "=", "c001");
        //     $builder->orWhere("id", "=", "c002");
        // })->get();
        // self::assertCount(2, $collection);


        // // whereNot(callback(Builder))
        // $collection = DB::table("categories")->whereNot(function (Builder $builder) {
        //     $builder->where("id", "=", "c001");
        // })->get();
        // self::assertCount(3, $collection);


        $collection = DB::table("categories")
            ->where("id", "=", "c001")
            ->orWhere("id", "=", "c002")->get();

        self::assertCount(2, $collection);

        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    public function testWhereBetween()
    {
        $this->seed(CategoriesSeeder::class);

        $collection = DB::table("categories")->whereBetween("created_at", ["2020-12-11 10:10:10", "2020-12-11 10:10:10"])->get();

        self::assertCount(4, $collection);

        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    public function testWhereIn()
    {
        $this->seed(CategoriesSeeder::class);

        $collecion = DB::table("categories")->whereIn("id", ["c001", "c002"])->get();

        self::assertCount(2, $collecion);

        $collecion->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    public function testWhereNull()
    {
        $this->seed(CategoriesSeeder::class);

        $collection = DB::table("categories")->whereNull("id")->get();

        self::assertCount(0, $collection);

        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    public function testWhereNotNull()
    {
        $this->seed(CategoriesSeeder::class);

        $collection = DB::table("categories")->whereNotNull("id")->get();

        self::assertCount(4, $collection);

        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    public function testWhereDate()
    {
        $this->seed(CategoriesSeeder::class);

        $collection = DB::table("categories")->whereDate("created_at", "=", "2020-12-11")->get();

        self::assertCount(4, $collection);

        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    public function testUpdate()
    {
        $this->seed(CategoriesSeeder::class);

        DB::table("categories")->where("id", "=", "c001")->update(["id" => "c008"]);

        $collection = DB::table("categories")->where("id", "=", "c008")->get();

        self::assertCount(1, $collection);

        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    public function testUpsert()
    {
        $this->seed(CategoriesSeeder::class);

        DB::table("categories")->updateOrInsert(["id" => "testing"], ["id" => "diubah"]);

        $collection = DB::table("categories")->where("id", "diubah")->get();

        self::assertCount(1, $collection);

        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    public function testIncrement()
    {
        $this->seed(CountersSeeder::class);

        DB::table("counters")->where("id", 1)->increment("counter", 1);

        $collection = DB::table("counters")->get();

        self::assertCount(1, $collection);

        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    public function testDelete()
    {
        $this->seed(CategoriesSeeder::class);

        DB::table("categories")->where("id", "c001")->delete();

        $collection = DB::table("categories")->where("id", "c001")->get();

        self::assertCount(0, $collection);

        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    public function testInsertTableProducts()
    {
        $this->seed(CategoriesSeeder::class);

        $categories = DB::table("categories")->get();
        self::assertCount(4, $categories);

        DB::table("products")->insert(["id" => "1", "name" => "headset", "description" => "headset gaming ltd", "price" => 60000, "category_id" => "c001"]);
        DB::table("products")->insert(["id" => "2", "name" => "headset", "description" => "headset gaming", "price" => 55000, "category_id" => "c002"]);

        $products = DB::table("products")->get();
        self::assertCount(2, $products);
    }

    public function testJoin()
    {
        $this->testInsertTableProducts();

        $categories = DB::table("categories")->get();
        self::assertCount(4, $categories);

        $products = DB::table("products")->get();
        self::assertCount(2, $products);

        $collection = DB::table("products")
            ->join("categories", "products.category_id", "=", "categories.id")
            ->select("products.id", "products.name", "products.price", "categories.name as category_name")
            ->get();

        self::assertCount(2, $collection);

        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    public function testOrder()
    {
        $this->testInsertTableProducts();

        $collection = DB::table("products")->orderBy("price", "asc")->orderBy("name", "desc")->get();

        self::assertCount(2, $collection);

        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    public function testPaging()
    {
        $this->seed(CategoriesSeeder::class);

        // $collection = DB::table("categories")
        //     ->skip(0)
        //     ->take(2)->get();

        // self::assertCount(2, $collection);
        // $collection->each(function ($item) {
        //     Log::info(json_encode($item));
        // });

        $collection = DB::table("categories")
            ->skip(2)
            ->take(2)->get();

        self::assertCount(2, $collection);
        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    public function testInsertManyCategories()
    {
        for ($i = 1; $i <= 50; $i++) {
            DB::table("categories")->insert([
                "id" => "C$i",
                "name" => "Title-$i",
                "description" => "Description-$i"
            ]);
        }

        $collection = DB::table("categories")->get();

        self::assertCount(50, $collection);
    }

    public function testChunk()
    {
        $this->testInsertManyCategories();

        DB::table("categories")
            ->orderBy("id")
            ->chunk(10, function ($categories) {
                self::assertNotNull($categories);
                Log::info("Start chunk");
                $categories->each(function ($item) {
                    Log::info(json_encode($item));
                });
                Log::info("End chunk");
            });
    }

    public function testLazy()
    {
        $this->testInsertManyCategories();

        // With Take
        // $collection = DB::table("categories")->orderBy("id")->lazy(3)->take(5);
        // self::assertNotNull($collection);

        // $collection->each(function ($item) {
        //     Log::info(json_encode($item));
        // });

        $collection = DB::table("categories")->orderBy("id")->lazy(3);
        self::assertNotNull($collection);

        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    public function testCursor()
    {
        $this->testInsertManyCategories();

        $collection = DB::table("categories")->orderBy("id")->cursor();
        self::assertNotNull($collection);

        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    public function testAggregate()
    {
        $this->testInsertTableProducts();

        // Max
        $collection = DB::table("products")->max("price");
        self::assertEquals(60000, $collection);

        // Min
        $collection = DB::table("products")->min("price");
        self::assertEquals(55000, $collection);

        // Avg
        $collection = DB::table("products")->avg("price");
        self::assertEquals(57500, $collection);

        // Sum
        $collection = DB::table("products")->sum("price");
        self::assertEquals(115000, $collection);

        // Count
        $collection = DB::table("products")->count("id");
        self::assertEquals(2, $collection);
    }

    public function testQueryBuilderRawAggregate()
    {
        $this->testInsertTableProducts();

        $collection = DB::table("products")
            ->select(
                DB::raw("count(id) as total_products"),
                DB::raw("max(price) as price_max"),
                DB::raw("min(price) as price_min")
            )->get();

        self::assertEquals(2, $collection[0]->total_products);
        self::assertEquals(60000, $collection[0]->price_max);
        self::assertEquals(55000, $collection[0]->price_min);

        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    public function testQueryBuilderAggregateGroupBy()
    {
        $this->testInsertTableProducts();

        $collection = DB::table("products")
            ->select("category_id", DB::raw("count(*) as total_products"))
            ->groupBy("category_id")
            ->orderBy("category_id", "desc")
            ->get();

        self::assertCount(2, $collection);

        self::assertEquals(1, $collection[0]->total_products);
        self::assertEquals("c002", $collection[0]->category_id);

        self::assertEquals(1, $collection[1]->total_products);
        self::assertEquals("c001", $collection[1]->category_id);

        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    public function testLocking()
    {
        $this->testInsertTableProducts();

        DB::transaction(function () {
            $collection = DB::table("products")
                ->where(["id" => "1"])
                ->lockForUpdate()
                ->get();
            self::assertCount(1, $collection);

            $collection->each(function ($item) {
                Log::info(json_encode($item));
            });
        });
    }

    public function testPaginate()
    {
        $this->seed(CategoriesSeeder::class);

        $paginate = DB::table("categories")->paginate(perPage: 2, page: 1);

        self::assertEquals(4, $paginate->total());
        self::assertEquals(1, $paginate->currentPage());
        self::assertEquals(2, $paginate->perPage());
        self::assertEquals(2, $paginate->lastPage());

        $collection = $paginate->items();
        foreach ($collection as $value) {
            Log::info(json_encode($value));
        }
    }

    public function testPaginateIteration()
    {
        $this->seed(CategoriesSeeder::class);

        $page = 1;

        while (true) {
            $paginate = DB::table("categories")->paginate(perPage: 2, page: $page);

            if ($paginate->isEmpty()) {
                break;
            }

            $collection = $paginate->items();

            foreach ($collection as $value) {
                self::assertNotNull($value);
                Log::info(json_encode($value));
            }
            $page++;
        }
    }

    public function testCursorPagination()
    {
        $this->seed(CategoriesSeeder::class);

        $cursor = "id";

        while (true) {
            $paginate = DB::table("categories")
                ->orderBy("id")
                ->cursorPaginate(perPage: 2, cursor: $cursor);

            foreach ($paginate->items() as $value) {
                self::assertNotNull($value);
                Log::info(json_encode($value));
            }

            $cursor = $paginate->nextCursor();
            if ($cursor == null) {
                break;
            }
        }
    }
}
