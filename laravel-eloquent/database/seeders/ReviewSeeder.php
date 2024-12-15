<?php

namespace Database\Seeders;

use App\Models\Products;
use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $review = new Review();
        $review->product_id = "p001";
        $review->rating = 5;
        $review->customer_id = "c001";
        $review->comment = "bagus banget";
        $review->save();

        $review = new Review();
        $review->product_id = "p001";
        $review->rating = 3;
        $review->customer_id = "c001";
        $review->comment = "lumayan";
        $review->save();
    }
}
