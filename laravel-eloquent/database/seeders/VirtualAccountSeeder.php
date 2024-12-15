<?php

namespace Database\Seeders;

use App\Models\VirtualAccount;
use App\Models\Wallets;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VirtualAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wallets = Wallets::where("customer_id", "c001")->firstOrFail();

        $va = new VirtualAccount();
        $va->bank = "BCA";
        $va->va_number = "123123";

        $wallets->va()->save($va);
    }
}
