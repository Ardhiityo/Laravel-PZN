<?php

namespace Database\Seeders;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();

        $todo = new Todo();
        $todo->title = "test";
        $todo->description = "test todos";
        $todo->user_id = $user->id;
        $todo->save();
    }
}
