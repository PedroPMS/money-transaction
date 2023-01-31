<?php

namespace MoneyTransaction\Infrastructure\Providers\Http\Transaction;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use MoneyTransaction\Domain\Services\Transaction\TransactionNotifier;
use MoneyTransaction\Infrastructure\Exceptions\TransactionNotificationException;
use Symfony\Component\HttpFoundation\Response;

class TransactionNotifierClient implements TransactionNotifier
{
    /**
     * @throws GuzzleException
     * @throws TransactionNotificationException
     */
    private function send(string $url): void
    {
        $client = new Client(['base_uri' => config('services.transaction_notifier.base_url')]);

        $statusCode = $client->get($url)->getStatusCode();

        if ($statusCode !== Response::HTTP_OK) {
            throw new TransactionNotificationException();
        }
    }

    /**
     * @throws GuzzleException
     * @throws TransactionNotificationException
     */
    public function sendNotification(): void
    {
        $this->send(config('services.transaction_notifier.notify_url'));
    }
}
