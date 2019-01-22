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

        $url    = 'https://www.tripoto.com/trip/hings-to-do-when-visiting-austin-texas-5c1b9cfa7563f';
        $domain = 'rental24h.com';
        $target = 'https://rental24h.com/usa/austin-airport/enterprise';
        $domain = app(\App\Services\AhrefParserService::class)->parse($domain, $url, $target);

        $this->assertTrue(true);
    }
}
