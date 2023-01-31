<?php

namespace App\Jobs\Transaction;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use MoneyTransaction\Application\Controllers\Transaction\Create;

class CreateTransaction implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private readonly string $payerId,
        private readonly string $payeeId,
        private readonly int $value
    ) {
    }

    public function handle(Create $create): void
    {
        $create->createTransaction(
            $this->payerId,
            $this->payeeId,
            $this->value
        );
    }
}
