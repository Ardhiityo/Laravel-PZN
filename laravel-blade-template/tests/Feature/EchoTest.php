<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Person;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EchoTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testEcho()
    {
        $person = new Person();
        $person->name = "Eko";
        $person->address = "Indonesia";

        $this->view("echo", ["person" => $person])
            ->assertSeeText("Eko : Indonesia");
    }
}
