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
    public function parse($domain, $url, $target, $update = false)
    {

        //$url  = 'https://aliving.co/travel/post/planning-a-road-trip-be-sure-to-stop-by-this-awesome-place';
        //$link = "https:\/\/rental24h.com\/australia\/underage\/under-21";

        $this->link = [];

        try {
            $key = md5($url . 'parser');

            if ($update) {
                $f = Cache::remember($key, 43200, function () use ($url) {
                    return file_get_contents($url);
                });
            } else {
                $f = Cache::get($key);
            }

            $matches = $this->findAhref($target, $f);

            if ( ! count($matches)) {
                $this->link['link'] = false;
                $matches            = $this->findAhref($domain, $f);
                if ( ! count($matches)) {

                    $this->link['domain'] = false;

                    return $this->link;
                }
            }

            $this->link['domain'] = true;
            $this->link['rel']    = stripos($matches[0], 'nofollow') ? 'nofollow' : '';

            $this->link['anchor'] = $matches[4] ?? $this->prepareAnchor($matches[4]);


        } catch (\Exception $e) {
            Cache::put($key, false, 43200);
            $this->link = false;
            Log::error($e);
        }

        return $this->link;

    }


    protected function findAhref($url, $f)
    {
        if ( ! $url) {
            return [];
        }

        $pattern = "/<a\s(.*)href(.*)?" . $this->removeHttp($url) . "(.*)>{1}(.*){1}<\/a>{1}/";

        preg_match($pattern, $f, $matches);

        return $matches;

    }


    protected function removeHttp($url)
    {

        $url = preg_replace("/(https?:\/\/)/", "", $url);

        return $url;

    }


    protected function prepareAnchor($anchor)
    {

        $anchor = trim(strip_tags($anchor));

        return $anchor;

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
