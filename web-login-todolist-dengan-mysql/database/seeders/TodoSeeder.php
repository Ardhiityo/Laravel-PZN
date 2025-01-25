<?php

namespace Database\Seeders;

use App\Models\Todo;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Todo::create([
            "id" => "1",
            "name" => "Belajar Laravel"
        ]);
        Todo::create([
            "id" => "2",
            "name" => "Belajar PHP"
        ]);
    }
}
