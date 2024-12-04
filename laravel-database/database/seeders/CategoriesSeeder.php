<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')
            ->insert(["id" => "c001", "name" => "gadget", "description" => "gadget category", "created_at" => "2020-12-11 10:10:10"]);
        DB::table('categories')
            ->insert(["id" => "c002", "name" => "acc", "description" => "accessories category", "created_at" => "2020-12-11 10:10:10"]);
        DB::table('categories')
            ->insert(["id" => "c003", "name" => "phone", "description" => "phoone category", "created_at" => "2020-12-11 10:10:10"]);
        DB::table('categories')
            ->insert(["id" => "c004", "name" => "cloth", "description" => "cloth category", "created_at" => "2020-12-11 10:10:10"]);
    }
}
