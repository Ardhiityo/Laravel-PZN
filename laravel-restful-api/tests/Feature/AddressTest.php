<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Contact;
use Database\Seeders\AddressSeeder;
use Database\Seeders\ContactSeeder;
use Database\Seeders\UserSeeder;
use Tests\TestCase;

class AddressTest extends TestCase
{
    public function test_create_address_success()
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $contact = Contact::first();

        $this->post("/api/contacts/$contact->id/addresses", [
            "street" => "jl. braga",
            "city" => "bandung",
            "province" => "jawa barat",
            "country" => "indonesia",
            "postal_code" => "42411",
        ], ["Authorization" => "test"])->assertStatus(201)
            ->assertJson([
                "data" => [
                    "street" => "jl. braga",
                    "city" => "bandung",
                    "province" => "jawa barat",
                    "country" => "indonesia",
                    "postal_code" => "42411",
                ]
            ]);
    }

    public function test_create_address_other_user()
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $contact = Contact::first();

        $this->post("/api/contacts/$contact->id/addresses", [
            "street" => "jl. braga",
            "city" => "bandung",
            "province" => "jawa barat",
            "country" => "indonesia",
            "postal_code" => "42411",
        ], ["Authorization" => "test2"])->assertStatus(404)
            ->assertJson([
                "errors" => [
                    "message" => ["not found"]
                ]
            ]);
    }

    public function test_create_address_failed()
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $contact = Contact::first();

        $this->post("/api/contacts/$contact->id/addresses", [
            "street" => "",
            "city" => "bandung",
            "province" => "jawa barat",
            "country" => "indonesia",
            "postal_code" => "",
        ], ["Authorization" => "test"])->assertStatus(400)
            ->assertJson([
                "errors" => [
                    "street" => [
                        "The street field is required."
                    ]
                ]
            ]);
    }

    public function test_create_address_notfound()
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $contact = Contact::first();

        $this->post("/api/contacts/11111/addresses", [
            "street" => "jl. braga",
            "city" => "bandung",
            "province" => "jawa barat",
            "country" => "indonesia",
            "postal_code" => "42411",
        ], ["Authorization" => "test"])->assertStatus(404)
            ->assertJson([
                "errors" => [
                    "message" => [
                        "not found"
                    ]
                ]
            ]);
    }

    public function test_get_success()
    {
        $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);

        $contact = Contact::first();
        $address = Address::first();

        $this->get("/api/contacts/$contact->id/addresses/$address->id", [
            "Authorization" => "test"
        ])->assertStatus(200)
            ->assertJson([
                "data" => [
                    "street" => "jl. braga",
                    "city" => "bandung",
                    "province" => "jawa barat",
                    "country" => "indonesia",
                    "postal_code" => "42411"
                ]
            ]);
    }

    public function test_get_failed_addresses()
    {
        $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);

        $contact = Contact::first();
        $address = Address::first();

        $this->get("/api/contacts/$contact->id/addresses/000", [
            "Authorization" => "test"
        ])->assertStatus(404)
            ->assertJson([
                "errors" => [
                    "message" => [
                        "not found"
                    ]
                ]
            ]);
    }

    public function test_get_failed_contact()
    {
        $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);

        $contact = Contact::first();
        $address = Address::first();

        $this->get("/api/contacts/000/addresses/$address->id", [
            "Authorization" => "test"
        ])->assertStatus(404)
            ->assertJson([
                "errors" => [
                    "message" => [
                        "not found"
                    ]
                ]
            ]);
    }

    public function test_get_failed_other_user()
    {
        $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);

        $contact = Contact::first();
        $address = Address::first();

        $this->get("/api/contacts/000/addresses/$address->id", [
            "Authorization" => "test2"
        ])->assertStatus(404)
            ->assertJson([
                "errors" => [
                    "message" => [
                        "not found"
                    ]
                ]
            ]);
    }

    public function test_update_success()
    {
        $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);

        $address = Address::first();
        $contact = Contact::first();

        $this->put("/api/contacts/$contact->id/addresses/$address->id", [
            "street" => "new",
            "city" => "new",
            "province" => "new",
            "country" => "new",
            "postal_code" => "new"
        ], ["Authorization" => "test"])->assertStatus(200)
            ->assertJson([
                "data" => [
                    "street" => "new",
                    "city" => "new",
                    "province" => "new",
                    "country" => "new",
                    "postal_code" => "new"
                ]
            ]);
    }

    public function test_update_failed_address()
    {
        $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);

        $address = Address::first();
        $contact = Contact::first();

        $this->put("/api/contacts/$contact->id/addresses/000", [
            "street" => "new",
            "city" => "new",
            "province" => "new",
            "country" => "new",
            "postal_code" => "new"
        ], ["Authorization" => "test"])->assertStatus(404)
            ->assertJson([
                "errors" => [
                    "message" => [
                        "not found"
                    ]
                ]
            ]);
    }

    public function test_update_failed_contact()
    {
        $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);

        $address = Address::first();
        $contact = Contact::first();

        $this->put("/api/contacts/000/addresses/$address->id", [
            "street" => "new",
            "city" => "new",
            "province" => "new",
            "country" => "new",
            "postal_code" => "new"
        ], ["Authorization" => "test"])->assertStatus(404)
            ->assertJson([
                "errors" => [
                    "message" => [
                        "not found"
                    ]
                ]
            ]);
    }

    public function test_delete_success()
    {
        $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);

        $contact = Contact::first();
        $address = Address::first();
        $this
            ->delete("/api/contacts/$contact->id/addresses/$address->id", headers: [
                "Authorization" => "test"
            ])->assertStatus(200)->assertJson([
                "data" => true
            ]);

        $address = Address::first();
        self::assertNull($address);
    }

    public function test_delete_failed()
    {
        $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);

        $contact = Contact::first();
        $address = Address::first();
        $this
            ->delete("/api/contacts/$contact->id/addresses/000", headers: [
                "Authorization" => "test"
            ])->assertStatus(404)->assertJson([
                "errors" => [
                    "message" => ["not found"]
                ]
            ]);
    }

    public function test_address_list_success()
    {
        $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);

        $contact = Contact::first();

        $this->get("/api/contacts/$contact->id/addresses", ["Authorization" => "test"])
            ->assertStatus(200)
            ->assertJson([
                "data" => [
                    [
                        "street" => "jl. braga",
                        "city" => "bandung",
                        "province" => "jawa barat",
                        "country" => "indonesia",
                        "postal_code" => "42411"
                    ]
                ]
            ]);
    }

    public function test_address_list_failed()
    {
        $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);

        $contact = Contact::first();

        $this->get("/api/contacts/000/addresses", ["Authorization" => "test"])
            ->assertStatus(404)
            ->assertJson([
                "errors" => [
                    "message" => [
                        "not found"
                    ]
                ]
            ]);
    }
}
