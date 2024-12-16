<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FormTest extends TestCase
{
    public function testSucces()
    {
        $result = $this->post("form/login", [
            "username" => "Eko",
            "password" => "Rahasia"
        ]);

        self::assertEquals(200, $result->status());

        Log::info($result->status());
    }

    public function testFailed()
    {
        $result = $this->post("form/login", [
            "username" => "",
            "password" => ""
        ]);

        self::assertEquals(400, $result->status());

        Log::info($result->status());
    }

    public function testViewForm()
    {
        $this->get("form")->assertSeeText("Username")->assertSeeText("Password");
    }

    public function testSubmitFormFailed()
    {
        $this->post("form", [
            "username" => "",
            "password" => ""
        ])->assertStatus(302);
    }

    public function testSubmitFormSuccess()
    {
        $this->post("form", [
            "username" => "eko",
            "password" => "eko"
        ])->assertStatus(200);
    }
}
