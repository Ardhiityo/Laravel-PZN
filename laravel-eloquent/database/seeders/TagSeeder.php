<?php

namespace Database\Seeders;

use App\Models\Products;
use App\Models\Tag;
use App\Models\Voucher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tag = new Tag();
        $tag->id = "pzn";
        $tag->name = "Programmer Zaman Now";
        $tag->save();

        $product = Products::find("p001");
        $product->tags()->attach("pzn");

        $voucher = Voucher::find("v001");
        $voucher->tags()->attach("pzn");
    }
}
