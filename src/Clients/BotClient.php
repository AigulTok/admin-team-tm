<?php

namespace App\Clients;

use GuzzleHttp\Client;

class BotClient
{
    public Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'http://localhost:8080',
            'timeout' => 2.0,
            'verify' => false,
        ]);
    }

    public function sendMessage(string $text)
    {
        $response = $this->client->request('POST', '/sendMessage', [
            'json' => [
                'text' => $text,
            ]]);
        return json_decode($response->getBody()->getContents());
    }
}
