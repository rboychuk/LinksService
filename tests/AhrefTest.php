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

        $url    = 'https://www.infographicbee.com/top-10-things-milan/';
        $domain = 'rental24h.com';
        $target = '';
        $domain = app(\App\Services\AhrefParserService::class)->parse($domain, $url, $target);

        $this->assertTrue(true);
    }
}
