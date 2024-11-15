<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FileStorageTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testStorage()
    {
        $storage = Storage::disk("local");

        $result = $storage->put("file.txt", "Hello World");

        self::assertEquals("Hello World", $result);
    }

    public function testStoragePublic()
    {
        $storage = Storage::disk("public");

        $result = $storage->put("file.txt", "Hello World");

        self::assertEquals("Hello World", $result);
    }
}
