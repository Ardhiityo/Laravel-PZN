<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Products;
use App\Models\Wallets;
use Tests\TestCase;
use App\Models\Customers;
use Database\Seeders\CategorySeeder;
use Database\Seeders\WalletsSeeder;
use Illuminate\Support\Facades\Log;
use Database\Seeders\CustomersSeeder;
use Database\Seeders\ImageSeeder;
use Database\Seeders\ProductsSeeder;
use Database\Seeders\VirtualAccountSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerTest extends TestCase
{
    public function testOneToOne()
    {
        $this->seed([CustomersSeeder::class, WalletsSeeder::class]);

        $customer = Customers::find("c001");
        self::assertNotNull($customer);

        $wallet = $customer->wallets;
        self::assertNotNull($wallet);
        self::assertEquals(12000, $wallet->amount);

        Log::info($wallet);
    }

    public function testOneToOneQuery()
    {
        $customer = new Customers();
        $customer->id = "cs01";
        $customer->name = "customer 1";
        $customer->email = "cs@.co";
        $customer->save();

        $wallet = new Wallets();
        $wallet->amount = 12000;
        $customer->wallets()->save($wallet);

        self::assertNotNull($wallet->customer_id);

        Log::info($wallet);
    }

    public function testHasOneThrough()
    {
        $this->seed([CustomersSeeder::class, WalletsSeeder::class, VirtualAccountSeeder::class]);

        $customer = Customers::find("c001");
        $va = $customer->va;

        self::assertEquals("BCA", $va->bank);

        Log::info($customer);
    }

    public function testManyToManyInsert()
    {
        $this->seed([CategorySeeder::class, ProductsSeeder::class, CustomersSeeder::class]);

        $customer = Customers::find("c001");
        $customer->likesProducts()->attach("p001");

        $result = $customer->likesProducts;

        self::assertCount(1, $result);

        Log::info($result);
    }

    public function testManyToManyDelete()
    {
        $this->testManyToManyInsert();

        $customer = Customers::find("c001");
        $customer->likesProducts()->detach("p001");

        $result = $customer->likesProducts;

        self::assertCount(0, $result);

        Log::Info($result);
    }

    public function testPivot()
    {
        $this->testManyToManyInsert();

        $customers = Customers::find("c001");

        $customers = $customers->likesProducts;
        Log::info($customers);

        foreach ($customers as $customer) {
            $pivot = $customer->pivot;
            self::assertNotNull($pivot->customer_id);
            self::assertNotNull($pivot->product_id);
            self::assertNotNull($pivot->created_at);
        }
    }

    public function testPivotModel()
    {
        $this->testManyToManyInsert();

        $customers = Customers::find("c001");

        $customers = $customers->likesProducts;
        Log::info($customers);

        foreach ($customers as $customer) {
            $pivot = $customer->pivot;
            $products = $pivot->products;
            $customers = $pivot->customers;

            self::assertNotNull($products);
            self::assertNotNull($customer);

            Log::info($products);
            Log::info($customers);
        }
    }

    public function testPivotModelCondition()
    {
        $this->testManyToManyInsert();

        $customers = Customers::find("c001");

        $customers = $customers->likesProductsLastWeek;
        Log::info($customers);

        foreach ($customers as $customer) {
            $pivot = $customer->pivot;
            $products = $pivot->products;
            $customers = $pivot->customers;

            self::assertNotNull($customer);
            self::assertNotNull($products);

            Log::info($customers);
            Log::info($products);
        }
    }

    public function testEagerWithQueryBuilder()
    {
        $this->seed([CategorySeeder::class, ProductsSeeder::class, CustomersSeeder::class, ImageSeeder::class, WalletsSeeder::class]);

        $customer = Customers::with(["wallets", "images"])->find("c001");

        self::assertNotNull($customer);

        Log::info($customer);
    }

    public function testEagerWithModel()
    {
        $this->seed([CategorySeeder::class, ProductsSeeder::class, CustomersSeeder::class, ImageSeeder::class, WalletsSeeder::class]);

        $customer = Customers::find("c001");

        self::assertNotNull($customer);

        Log::info($customer);
    }
}
