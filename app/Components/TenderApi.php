<?php

namespace App\Components;

use http\Client;

class TenderApi
{
    public \GuzzleHttp\Client $client;

    public function __construct()
    {
       $this->client = new \GuzzleHttp\Client([
           'base_uri' => 'https://public.api.openprocurement.org/api/0/',
            'timeout' => 2.0
       ]);
    }
}
