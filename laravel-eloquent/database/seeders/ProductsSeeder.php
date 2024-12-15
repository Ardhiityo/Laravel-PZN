<?php

namespace Database\Seeders;

use App\Models\Products;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $product = new Products();
        $product->id = "p001";
        $product->name = "product 1";
        $product->price = 15000;
        $product->stock = 4;
        $product->category_id = "c001";
        $product->save();

        $product = new Products();
        $product->id = "p002";
        $product->name = "product 2";
        $product->price = 20000;
        $product->stock = 4;
        $product->category_id = "c001";
        $product->save();
    }
}
