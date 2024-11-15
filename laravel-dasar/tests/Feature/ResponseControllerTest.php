<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResponseControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testResponse()
    {
        $this->get('/response')
            ->assertStatus(200)
            ->assertSeeText("Hello World");
    }

    public function testHeader()
    {
        $this->get('/response/header')
            ->assertHeader('Content-Type', 'application/json')
            ->assertHeader('App', 'Belajar Laravel')
            ->assertStatus(200)
            ->assertSeeText("PZN")
            ->assertSeeText("20");
    }

    public function testView()
    {

        $this->get('/response/view')->assertSeeText("PZN");
    }

    public function testJson()
    {
        // Jika menggunakan jsn maka akan secara otomatis memiliki header include dengan content typenya
        $this->get('/response/json')->assertJson(['name' => 'PZN', 'age' => 20]);
    }

    public function testFile()
    {
        // Jika menggunakan jsn maka akan secara otomatis memiliki header include dengan content typenya
        $this->get('/response/file')->assertHeader('Content-Type', 'image/png');
    }

    public function testDowload()
    {
        // Jika menggunakan jsn maka akan secara otomatis memiliki header include dengan content typenya
        $this->get('/response/download')->assertDownload('pzn.png');
    }
}
