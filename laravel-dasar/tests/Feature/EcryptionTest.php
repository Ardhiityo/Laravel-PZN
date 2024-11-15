<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;

class EcryptionTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testEncryption()
    {
        $encrypt = Crypt::encrypt('PZN');

        var_dump($encrypt);

        $decrypt = Crypt::decrypt($encrypt);

        var_dump($decrypt);

        self::assertEquals('PZN', $decrypt);
    }
}
