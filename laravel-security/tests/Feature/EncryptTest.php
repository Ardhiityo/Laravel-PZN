<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;

class EncryptTest extends TestCase
{
    public function testCrypt()
    {
        $password = "rahasia";

        $encrypt = Crypt::encrypt($password);
        $decrypt = Crypt::decrypt($encrypt);

        self::assertEquals($password, $decrypt);
    }
}
