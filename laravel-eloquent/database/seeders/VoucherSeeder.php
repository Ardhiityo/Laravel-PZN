<?php

namespace Database\Seeders;

use App\Models\Voucher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $voucher = new Voucher();
        $voucher->id = "v001";
        $voucher->name = "flashsale";
        $voucher->voucher_code = "123";
        $voucher->is_active = true;
        $voucher->save();
    }
}
