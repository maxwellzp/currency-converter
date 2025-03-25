<?php

declare(strict_types=1);

namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ApiService
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function fetchData(string $apiUrl): array
    {
        try {
            $response = $this->client->request('GET', $apiUrl, [
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ]);

            $json = $response->getBody()->getContents();

            if (!json_validate($json)) {
                throw new \Exception('Json response is not valid');
            }
        } catch (GuzzleException $e) {
            return ['error' => $e->getMessage()];
        }
        return [$response->getStatusCode(), $json];
    }
}