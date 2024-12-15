<?php

namespace Tests\Feature;

use App\Models\Address;
use Tests\TestCase;
use App\Models\Person;
use Carbon\Carbon;
use Database\Seeders\PersonSeeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PersonTest extends TestCase
{
    public function testPerson()
    {
        $person = new Person();
        $person->first_name = "Eko";
        $person->last_name = "Khannedy";
        $person->save();

        self::assertEquals("EKO Khannedy", $person->full_name);

        $person->full_name = "Budi Nugraha";
        $person->save();

        self::assertEquals("BUDI Nugraha", $person->full_name);

        Log::info($person);
    }

    public function testAttributeCasting()
    {
        $person = new Person();
        $person->first_name = "Eko";
        $person->last_name = "Khannedy";
        $person->save();

        self::assertNotNull($person->created_at);
        self::assertNotNull($person->updated_at);

        self::assertInstanceOf(Carbon::class, $person->created_at);
        self::assertInstanceOf(Carbon::class, $person->updated_at);

        Log::info($person);
    }

    public function testCustomCast()
    {
        $person = new Person();
        $person->first_name = "Eko";
        $person->last_name = "Khannedy";
        $person->address = new Address("jalan belum jadi", "bandung", "indonesia", "123");

        $result = $person->save();
        self::assertTrue($result);

        self::assertInstanceOf(Address::class, $person->address);

        self::assertEquals("jalan belum jadi", $person->address->street);

        self::assertEquals("bandung", $person->address->city);

        self::assertEquals("indonesia", $person->address->country);

        self::assertEquals("123", $person->address->postal_code);
    }

    public function testCastTimestamp()
    {
        $person = new Person();
        $person->first_name = "Eko";
        $person->last_name = "Khannedy";
        $person->save();

        $person = Person::query()->get();
        self::assertNotNull($person);

        $result = $person->toJson(JSON_PRETTY_PRINT);

        Log::info($result);
    }
}
