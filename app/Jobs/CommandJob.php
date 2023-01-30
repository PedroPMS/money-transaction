<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Picpay\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Picpay\Shared\Domain\Bus\Command\CommandInterface;

class CommandJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $commandName;

    private string $handlerName;

    public function __construct(
        private readonly CommandInterface $command,
        private readonly CommandHandlerInterface $handler
    ) {
        $this->commandName = get_class($this->command);
        $this->handlerName = get_class($this->handler);
    }

    public function handle(): void
    {
        $this->handler->__invoke($this->command);
    }
}
