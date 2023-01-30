<?php

namespace MoneyTransaction\Shared\Domain;

interface UuidGeneratorInterface
{
    public function generate(): string;
}
