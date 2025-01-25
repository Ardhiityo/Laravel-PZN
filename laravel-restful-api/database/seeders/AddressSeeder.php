<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contact = Contact::first();

        $address = new Address();
        $address->street = "jl. braga";
        $address->city = "bandung";
        $address->province = "jawa barat";
        $address->country = "indonesia";
        $address->postal_code = "42411";
        $address->contact_id = $contact->id;
        $address->save();
    }
}
