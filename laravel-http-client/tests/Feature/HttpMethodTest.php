<?php

namespace Tests\Feature;

use Illuminate\Http\Client\RequestException;
use Tests\TestCase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class HttpMethodTest extends TestCase
{
    public function testHTTP()
    {
        $response = Http::get('https://eovkp0h5dtd7x0w.m.pipedream.net');
        self::assertTrue($response->ok());
        self::assertEquals(200, $response->getStatusCode());

        $response = Http::post('https://eovkp0h5dtd7x0w.m.pipedream.net');
        self::assertTrue($response->ok());
        self::assertEquals(200, $response->getStatusCode());

        $response = Http::patch('https://eovkp0h5dtd7x0w.m.pipedream.net');
        self::assertTrue($response->ok());
        self::assertEquals(200, $response->getStatusCode());

        $response = Http::delete('https://eovkp0h5dtd7x0w.m.pipedream.net');
        self::assertTrue($response->ok());
        self::assertEquals(200, $response->getStatusCode());
    }

    public function testResponse()
    {
        $response = Http::get('https://eovkp0h5dtd7x0w.m.pipedream.net');

        self::assertEquals('Hello world!', $response->getBody());
    }

    public function testQueryParam()
    {
        $response = Http::withQueryParameters(['page' => 15])
            ->get(
                'https://eovkp0h5dtd7x0w.m.pipedream.net',
            );

        self::assertEquals('Hello world!', $response->getBody());
    }

    public function testHeader()
    {
        $response = Http::withHeaders([
            'Content-type' => 'application/json',
            'Author' => "Arya"
        ])->withQueryParameters([
            'page' => 10
        ])->get('https://eovkp0h5dtd7x0w.m.pipedream.net');

        self::assertEquals('Hello world!', $response->getBody());
    }

    public function testCookie()
    {
        $response = Http::withHeaders([
            'Content-type' => 'application/json',
            'Author' => "Arya"
        ])->withQueryParameters([
            'page' => 10
        ])->withCookies(
            [
                'session' => 12345,
                'user' => 'Arya'
            ],
            'eovkp0h5dtd7x0w.m.pipedream.net'
        )->get('https://eovkp0h5dtd7x0w.m.pipedream.net');

        self::assertEquals('Hello world!', $response->getBody());
    }

    public function testForm()
    {
        $response = Http::asForm()
            ->withHeaders([
                'Content-type' => 'application/json',
                'Author' => "Arya"
            ])->withQueryParameters([
                'page' => 10
            ])->withCookies(
                [
                    'session' => 12345,
                    'user' => 'Arya'
                ],
                'eovkp0h5dtd7x0w.m.pipedream.net'
            )->post(
                'https://eovkp0h5dtd7x0w.m.pipedream.net',
                [
                    'username' => 'admin',
                    'password' => 'rahasia'
                ]
            );

        self::assertEquals('Hello world!', $response->getBody());
    }

    public function testMultipart()
    {
        $response = Http::asMultipart()
            ->attach('avatar', asset('favicon.ico'), 'logo.ico')
            ->withHeaders([
                'Content-type' => 'application/json',
                'Author' => "Arya"
            ])->withQueryParameters([
                'page' => 10
            ])->withCookies(
                [
                    'session' => 12345,
                    'user' => 'Arya'
                ],
                'eovkp0h5dtd7x0w.m.pipedream.net'
            )->post(
                'https://eovkp0h5dtd7x0w.m.pipedream.net',
                [
                    'username' => 'admin',
                    'password' => 'rahasia'
                ]
            );

        self::assertEquals('Hello world!', $response->getBody());
    }

    public function testJson()
    {
        $response = Http::asJson()
            ->post('https://eovkp0h5dtd7x0w.m.pipedream.net', [
                'username' => 'admin',
                'password' => 'admin'
            ]);

        self::assertEquals(200, $response->getStatusCode());
    }

    public function testTimeout()
    {
        $response = Http::timeout(seconds: 2)
            ->asJson()
            ->post('https://eovkp0h5dtd7x0w.m.pipedream.net', [
                'username' => 'admin',
                'password' => 'admin'
            ]);

        self::assertEquals(200, $response->getStatusCode());
    }

    public function testRetry()
    {
        $response = Http::timeout(seconds: 2)
            ->retry(times: 5, sleepMilliseconds: 1000)
            ->asJson()
            ->post('https://eovkp0h5dtd7x0w.m.pipedream.net', [
                'username' => 'admin',
                'password' => 'admin'
            ]);

        self::assertEquals(200, $response->getStatusCode());
    }
    public function testException()
    {
        $this->expectException(RequestException::class);

        $response = Http::get('https://programmerzamannow.com/salah', [
            'username' => 'admin',
            'password' => 'admin'
        ])->throw();

        self::assertEquals(404, $response->getStatusCode());
    }
}
