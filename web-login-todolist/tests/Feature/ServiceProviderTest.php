<?php

namespace Tests\Feature;

use App\Service\Service;
use App\Service\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ServiceProviderTest extends TestCase
{

    public UserService $userService;

    public function setUp(): void
    {
        parent::setUp();

        $this->userService = $this->app->make(UserService::class);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testServiceProvider()
    {
        $this->assertNotNull($this->userService);
    }
}
