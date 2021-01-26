<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class Weather
{
    const JSON_RPC_VERSION = '2.0';

    const METHOD_URI = 'api';

    protected $client;

    public function __construct() {
        $this->client = new Client([
            'headers'  => ['Content-Type' => 'application/json'],
            'timeout'  => 3,
            'base_uri' => config('services.weather.url'),
        ]);
    }

    public function send(string $method, array $params): array {
        $response = $this->client
            ->post(self::METHOD_URI, [
                RequestOptions::JSON => [
                    'jsonrpc' => self::JSON_RPC_VERSION,
                    'id'      => time(),
                    'method'  => "weather.$method",
                    'params'  => $params
                ]
            ])->getBody()->getContents();

        return json_decode($response, true);
    }
}