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

        $url    = 'http://www.whatsyourtagblog.com/best-cars-for-your-road-trip-in-the-usa/';
        $domain = 'rental24h.com';
        $target = 'https://rental24h.com/usa/company/nu';
        $domain = app(\App\Services\AhrefParserService::class)->parse($domain, $url, $target);

        $this->assertTrue(true);
    }
}
