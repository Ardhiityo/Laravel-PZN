<?php

namespace Tests\Feature;

use App\Models\Contact;
use Tests\TestCase;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Database\Seeders\ContactSeeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class GateTest extends TestCase
{
    public function testGate()
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $user = User::where("email", "pzn@test")->first();
        $contact = Contact::where("user_id", $user->id)->first();
        Auth::login($user);

        self::assertTrue(Gate::allows("get-contact", $contact));
    }

    public function testGateMethod()
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $user = User::first();

        //jika belum login maka akan false
        Auth::login($user);

        $contact = Contact::where("user_id", $user->id)->first();
        self::assertTrue(Gate::allows("get-contact", $contact));
    }

    public function testGateNonLogin()
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $user = User::first();

        $contact = Contact::where("user_id", $user->id)->first();
        $gate = Gate::forUser($user);

        //Gate::forUser() digunakan untuk memeriksa izin (authorization) untuk pengguna tertentu tanpa harus login sebagai pengguna tersebut.
        self::assertTrue(Gate::forUser($user)
            ->allows("get-contact", $contact));
    }

    public function testGateResponse()
    {
        $this->seed([UserSeeder::class]);

        $user = User::first();
        Auth::login($user);

        $gate = Gate::inspect("create-contact");

        self::assertFalse($gate->allowed());
        self::assertEquals("You're not admin", $gate->message());
    }
}
