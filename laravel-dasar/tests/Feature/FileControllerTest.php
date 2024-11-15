<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;

class FileControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUpload()
    {
        $image = UploadedFile::fake()->image('pzn.png');
        $this->post('/file/upload', [
            'picture' => $image
        ])->assertSeeText("OK pzn.png");
    }
}
