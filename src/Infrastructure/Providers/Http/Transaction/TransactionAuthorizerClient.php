<?php

namespace MoneyTransaction\Infrastructure\Providers\Http\Transaction;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use MoneyTransaction\Domain\Services\Transaction\TransactionAuthorizer;

class TransactionAuthorizerClient implements TransactionAuthorizer
{
    /**
     * @return array<string, string>
     *
     * @throws GuzzleException
     */
    private function send(string $url): array
    {
        $client = new Client(['base_uri' => config('services.transaction_autorizer.base_url')]);

        $response = $client->get($url);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @throws GuzzleException
     */
    public function isAutorized(): bool
    {
        $message = $this->send(config('services.transaction_autorizer.autorizer_url'))['message'];

        return $message === config('services.transaction_autorizer.autorized_message');
    }
}
