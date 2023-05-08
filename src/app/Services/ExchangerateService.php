<?php

namespace App\Services;

use App\Services\CurrencyExchangeServiceInterface;
use GuzzleHttp\Client;

class ExchangerateService implements CurrencyExchangeServiceInterface
{

    public function __construct(protected Client $client)
    {
    }

    public function getSymbols(): array
    {
        // next build an exchange rate handler to handle providers
        $req_url = 'https://api.exchangerate.host/latest';

        $body = $this->client->get($req_url)->getBody();

        return json_decode($body, true);
    }

    public function convert(string $from, string $into, float $amount): float
    {
        return 23.5;
    }
}
