<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Contact;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where("email", "pzn@test")->first();

        $contact = new Contact();
        $contact->name = "pzn";
        $contact->email = "pzn@test";
        $contact->phone = "123";
        $contact->address = "bandung";
        $contact->user_id = $user->id;
        $contact->save();
    }
}
