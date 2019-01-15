<?php

namespace App\Services;

use GuzzleHttp\Client as Client;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Support\Facades\Cache;

class MozLinkApiService
{

    protected $metrics = [
        'ut'    => 'Title',
        'uu'    => 'Canonical URL',
        'ueid'  => 'External Equity Links',
        'uid'   => 'Links',
        'umrp'  => 'MozRank: URL',
        'fmrp'  => 'MozRank: Subdomain',
        'fspsc' => 'Subdomain Spam Score',
        'us'    => 'HTTP Status Code',
        'upa'   => 'Page Authority',
        'pda'   => 'Domain Authority',
        'ulc'   => 'Time last crawled'
    ];


    /**
     * A basic test example.
     *
     * @return void
     */
    public function getMetrics($url, $update = false)
    {

        $client = new Client(['http_errors' => false]);

        $accessID  = "mozscape-20a941b7de";
        $secretKey = "9a7fbfb60876233101c42fdcaceb50e7";

        $expires = time() + 300;

        $stringToSign = $accessID . "\n" . $expires;

        $binarySignature = hash_hmac('sha1', $stringToSign, $secretKey, true);

        $urlSafeSignature = urlencode(base64_encode($binarySignature));

        $cols = 103683246117 + 144115188075855872;

        $limit = "1";

        $requestUrl = "http://lsapi.seomoz.com/linkscape/url-metrics/" . urlencode($url) . "?Cols=" . $cols . "&Limit=" . $limit . "&AccessID=" . $accessID . "&Expires=" . $expires . "&Signature=" . $urlSafeSignature;

        $res = [];

        try {

            $key = md5($url . 'moz');

            if ($update) {
                $body = Cache::remember($key, 43200, function () use ($client, $requestUrl) {
                    sleep(11);
                    $response = $client->get($requestUrl);
                    $body     = $response->getBody()->getContents();

                    $body = json_decode($body);

                    return $body;

                });
            } else {
                $body = Cache::get($key);
            }

            if ($body) {
                foreach ($this->metrics as $key => $metric) {
                    if (property_exists($body, $key)) {
                        $res[$key] = is_real($body->$key) ? round($body->$key, 2) : $body->$key;
                    } else {
                        $res[$key] = 'disable';

                    }
                }
            }


        } catch (BadResponseException $e) {

        }

        return $res;

    }
}
