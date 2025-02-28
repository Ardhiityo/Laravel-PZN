<?php

namespace Tests\Feature;

use App\MathHelper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MathHelperTest extends TestCase
{
    public function testOnce()
    {
        //Once akan di eksekusi sekali selama nilai yang diberikan selalu sama
        $result = MathHelper::add(5, 5);
        $result2 = MathHelper::add(5, 5);
        $result3 = MathHelper::add(5, 50);

        self::assertEquals(10, $result);
        self::assertEquals(10, $result2);
        self::assertEquals(55, $result3);
    }
}
