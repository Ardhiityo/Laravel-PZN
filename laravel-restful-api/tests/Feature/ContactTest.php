<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Contact;
use Database\Seeders\UserSeeder;
use Database\Seeders\ContactSeeder;
use Illuminate\Support\Facades\Log;

class ContactTest extends TestCase
{
    public function test_create_contact_success()
    {
        $this->seed(UserSeeder::class);

        $this->post("/api/contacts", [
            "firstname" => "Eko",
            "lastname" => "Khannedy",
            "email" => "pzn@gmail.com",
            "phone" => "12345"
        ], [
            "Authorization" => "test"
        ])
            ->assertStatus(201)
            ->assertJson([
                "data" => [
                    "first_name" => "Eko",
                    "last_name" => "Khannedy",
                    "email" => "pzn@gmail.com",
                    "phone" => "12345"
                ]
            ]);
    }

    public function test_create_contact_failed()
    {
        $this->seed(UserSeeder::class);

        $this->post("/api/contacts", [
            "firstname" => "Eko",
            "lastname" => "Khannedy",
            "email" => "pzn",
            "phone" => "12345"
        ], [
            "Authorization" => "test"
        ])
            ->assertStatus(400)
            ->assertJson([
                "errors" => [
                    "email" => [
                        "The email field must be a valid email address."
                    ]
                ]
            ]);
    }

    public function test_create_contact_unauthorized()
    {
        $this->seed(UserSeeder::class);

        $this->post(
            "/api/contacts",
            [
                "firstname" => "Eko",
                "lastname" => "Khannedy",
                "email" => "pzn",
                "phone" => "12345"
            ]
        )
            ->assertStatus(401)
            ->assertJson([
                "errors" => [
                    "message" => [
                        "Unauthorized"
                    ]
                ]
            ]);
    }

    public function test_get_contact_success()
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $contact = Contact::first();

        $this->get("/api/contacts/$contact->id", [
            "Authorization" => "test"
        ])->assertStatus(200)
            ->assertJson(
                [
                    "data" => [
                        "id" => $contact->id,
                        "first_name" => $contact->firstname,
                        "last_name" => $contact->lastname,
                        "email" => $contact->email,
                        "phone" => $contact->phone
                    ]
                ]
            );
    }

    public function test_get_another_contact()
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $contact = Contact::first();

        $this->get("/api/contacts/$contact->id", [
            "Authorization" => "test2"
        ])->assertStatus(404)
            ->assertJson(
                [
                    "errors" => [
                        "message" => [
                            "not found"
                        ]
                    ]
                ]
            );
    }

    public function test_update_contact_success()
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $contact = Contact::first();

        $this->put("/api/contacts/$contact->id", [
            "firstname" => "diganti",
            "lastname" => "ganti lagi",
            "email" => "ganti@gmail.com",
            "phone" => "333"
        ], ["Authorization" => "test"])->assertStatus(200)
            ->assertJson([
                "data" => [
                    "first_name" => "diganti",
                    "last_name" => "ganti lagi",
                    "email" => "ganti@gmail.com",
                    "phone" => "333"
                ]
            ]);
    }

    public function test_update_contact_failed()
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $contact = Contact::first();

        $this->put("/api/contacts/$contact->id", [
            "firstname" => "",
            "lastname" => "ganti lagi",
            "email" => "ganti@gmail.com",
            "phone" => "333"
        ], ["Authorization" => "test"])->assertStatus(400)
            ->assertJson([
                "errors" => [
                    "firstname" => [
                        "The firstname field is required."
                    ]
                ]
            ]);
    }

    public function test_delete_success()
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $contact = Contact::first();

        $this->delete("/api/contacts/$contact->id", headers: ["Authorization" => "test"])->assertStatus(200)->assertJson([
            "data" => true
        ]);
    }

    public function test_delete_failed()
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $contact = Contact::first();

        $this->delete(
            "/api/contacts/000",
            headers: ["Authorization" => "test"]
        )->assertStatus(404)->assertJson([
            "errors" => [
                "message" => [
                    "not found"
                ]
            ]
        ]);
    }

    public function test_search_firstname()
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $result = $this->get("/api/contacts?name=first", [
            "Authorization" => "test"
        ])->assertStatus(200)->json();

        Log::info($result);

        self::assertEquals(10, count($result["data"]));
        self::assertEquals(1, $result["meta"]["current_page"]);
    }

    public function test_search_lastname()
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $result = $this->get("/api/contacts?name=last", [
            "Authorization" => "test"
        ])->assertStatus(200)->json();

        Log::info($result);

        self::assertEquals(10, count($result["data"]));
        self::assertEquals(1, $result["meta"]["current_page"]);
    }

    public function test_search_phone()
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $result = $this->get("/api/contacts?phone=11111", [
            "Authorization" => "test"
        ])->assertStatus(200)->json();

        Log::info($result);

        self::assertEquals(10, count($result["data"]));
        self::assertEquals(1, $result["meta"]["current_page"]);
    }

    public function test_search_email()
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $result = $this->get("/api/contacts?email=pzn@gmail.com", [
            "Authorization" => "test"
        ])->assertStatus(200)->json();

        Log::info($result);

        self::assertEquals(1, count($result["data"]));
        self::assertEquals(1, $result["meta"]["current_page"]);
    }

    public function test_next_page()
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $result = $this->get("/api/contacts?name=first&page=2&size=5", [
            "Authorization" => "test"
        ])->assertStatus(200)->json();

        Log::info($result);

        self::assertEquals(5, count($result["data"]));
        self::assertEquals(2, $result["meta"]["current_page"]);
    }

    public function test_notfound()
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $result = $this->get("/api/contacts?name=salah", [
            "Authorization" => "test"
        ])->assertStatus(200)->json();

        Log::info($result);

        self::assertEquals(0, count($result["data"]));
        self::assertEquals(1, $result["meta"]["current_page"]);
    }
}
