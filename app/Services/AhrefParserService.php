<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AhrefParserService
{

    protected $anchor;

    protected $rel;

    protected $url;

    protected $link = [];


    /**
     * A basic test example.
     *
     * @return void
     */
    public function parse($domain, $url)
    {

        //$url  = 'https://aliving.co/travel/post/planning-a-road-trip-be-sure-to-stop-by-this-awesome-place';
        //$link = "https:\/\/rental24h.com\/australia\/underage\/under-21";

        $this->link = [];

        try {
            $key = md5($url . 'parser');

            $f = Cache::remember($key, 28800, function () use ($url) {
                return file_get_contents($url);
            });

            preg_match('/<a[^>]* href=[\'"].*?' . $domain . '.*?[\'"]?>(.*?)<\/a>/',
                $f, $matches);

            if (count($matches)) {

                preg_match('/rel=[\'"]?(nofollow|dofollow)[\'"]?/',
                    $matches[0], $rel);

                $this->link['anchor'] = $matches[1] ?? $matches[1];
                $this->link['rel']    = $rel[1] ?? $rel[1];

            };


        } catch (\Exception $e) {
            Cache::put($key, false, 28800);
            $this->link = false;
            Log::error($e);
        }

        return $this->link;

    }


    public function getAnchor()
    {
        return $this->anchor;
    }


    public function getRel()
    {
        return $this->rel;
    }

}
