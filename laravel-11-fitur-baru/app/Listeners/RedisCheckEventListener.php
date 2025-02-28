<?php

namespace App\Listeners;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Foundation\Events\DiagnosingHealth;

class RedisCheckEventListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(DiagnosingHealth $event): void
    {
        $response = Redis::ping();
        if ($response == 'PONG') {
            Log::info('Redis is up');
        } else {
            Log::info("Redis down");
            throw new Exception('Redis is down');
        }
    }
}
