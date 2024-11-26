<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SwitchTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testSwitch()
    {
        $this->view('switch', ["value" => "A"])
            ->assertSee("Memuaskan");
        $this->view('switch', ["value" => "B"])
            ->assertSee("Bagus");
        $this->view('switch', ["value" => "C"])
            ->assertSee("Cukup");
        $this->view('switch', ["value" => "D"])
            ->assertSee("Tidak Lulus");
    }
}
