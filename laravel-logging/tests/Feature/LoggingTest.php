<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoggingTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLogging()
    {
        Log::warning("This is a warning");
        Log::error("This is an error");
        Log::info("This is an info");
        Log::notice("This is a notice");
        Log::debug("This is a debug");
        Log::alert("This is an alert");
        Log::critical("This is a critical");
        Log::emergency("This is an emergency");
        $this->assertTrue(true);
    }

    public function testContext()
    {
        Log::info("This is an info", ["name" => "John Doe"]);
        $this->assertTrue(true);
    }

    public function testWithContext()
    {
        Log::withContext(["name" => "Eko"]);
        Log::info("This is an info with context");
        Log::info("This is an info with context");
        $this->assertTrue(true);
    }

    public function testChannel()
    {
        $slackLogger = Log::channel("slack");
        $slackLogger->error("This is an error from slack");

        // Default logger
        // Log::info("This is an info");

        self::assertTrue(true);
    }
    public function testHandler()
    {
        $logger = Log::channel('file');
        $logger->info("This is an info");
        $logger->warning("This is a warning");
        $logger->error("This is an error");

        self::assertTrue(true);
    }
}
