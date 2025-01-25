<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();

        $contact = new Contact();
        $contact->firstname = "test123";
        $contact->lastname = "456";
        $contact->email = "pzn@gmail.com";
        $contact->phone = "12345";
        $contact->user_id = $user->id;
        $contact->save();

        for ($i = 1; $i < 50; $i++) {
            Contact::create([
                "firstname" => "first$i",
                "lastname" => "last$i",
                "email" => "pzn$i@gmail.com",
                "phone" => "11111",
                "user_id" => $user->id
            ]);
        }
    }
}
