<?php

namespace App\Providers;

use GuzzleHttp\Client;

class BasePriceProvider
{
    public function __construct(
        private Client $client
    )
    {

    }

    /**
     * @param string $apiUrl
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function makeApiRequest(string $apiUrl): array
    {
        $response = $this->client->request('GET', $apiUrl);
        $json = $response->getBody()->getContents();
        if (!json_validate($json)) {
            throw new \Exception('Json response is not valid');
        }
        return [$response->getStatusCode(), $json];
    }
}