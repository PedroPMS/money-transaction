<?php

namespace App\Jobs\Transaction;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use MoneyTransaction\Application\Controllers\Transaction\Notify;
use MoneyTransaction\Domain\ValueObjects\Transaction\TransactionId;

class NotifyTransaction implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly TransactionId $transactionId)
    {
    }

    public function handle(Notify $notifier): void
    {
        $notifier->notify($this->transactionId);
    }
}
