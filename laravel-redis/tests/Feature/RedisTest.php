<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Redis;
use Tests\TestCase;
use Illuminate\Support\Facades\Log;

class RedisTest extends TestCase
{
    public function testRedis()
    {
        $redis = Redis::ping();
        self::assertEquals('PONG', $redis);
    }
}
