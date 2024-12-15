<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Products;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $image = new Image();
        $image->url = "www.pzn.com/images/1";
        $image->imageable_id = "p001";
        $image->imageable_type = "product";
        $image->save();
    }
}
