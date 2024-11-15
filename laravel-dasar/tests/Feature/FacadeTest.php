<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Config;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FacadeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testConfig()
    {
        // Menggunakan Helper Function
        $config1 = config("contoh.author.firstName");

        // Menggunakan Facade
        $config2 = Config::get("contoh.author.firstName");

        self::assertSame($config1, $config2);

        // var_dump((Config::all()));
    }

    public function testFacadeMock()
    {
        Config::shouldReceive('get')
            ->with('contoh.author.firstName')
            ->andReturn('Eko Keren');

        $config = Config::get('contoh.author.firstName');

        self::assertSame('Eko Keren', $config);
    }
}
