<?php

namespace Database\Seeders;

use App\Models\Wallets;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WalletsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wallet = new Wallets();
        $wallet->customer_id = "c001";
        $wallet->amount = 12000;
        $wallet->save();
    }
}
