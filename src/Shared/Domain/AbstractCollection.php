<?php

declare(strict_types=1);

namespace MoneyTransaction\Shared\Domain;

use InvalidArgumentException;

abstract class AbstractCollection
{
    /** @var array<object> */
    private array $items;

    /** @param  array<object>  $items  */
    public function __construct(array $items = [])
    {
        $this->arrayOf($this->type(), $items);
        $this->items = $items;
    }

    /** @param  array<object>  $items  */
    private function arrayOf(string $class, array $items): void
    {
        foreach ($items as $item) {
            $this->instanceOf($class, $item);
        }
    }

    private function instanceOf(string $class, object $item): void
    {
        if (! $item instanceof $class) {
            throw new InvalidArgumentException(
                sprintf('The object <%s> is not an instance of <%s>', $class, get_class($item))
            );
        }
    }

    abstract protected function type(): string;

    public function count(): int
    {
        return count($this->all());
    }

    /** @return array<object> */
    public function all(): array
    {
        return $this->items;
    }
}
