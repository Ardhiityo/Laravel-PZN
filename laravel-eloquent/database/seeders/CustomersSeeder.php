<?php

namespace Database\Seeders;

use App\Models\Customers;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = new Customers();
        $customers->id = "c001";
        $customers->name = "eko";
        $customers->email = "pzn@.co";
        $customers->save();
    }
}
