<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AhrefTest extends TestCase
{

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {

        $url    = 'http://www.rs-royal.com/exploring-atlanta-places-you-cannot-miss/';
        $domain = 'rental24h.com';
        $target = 'https://rental24h.com/usa/atlanta-airport';
        $domain = app(\App\Services\AhrefParserService::class)->parse($domain, $url, $target, true);

        $this->assertTrue(true);

    }
}
