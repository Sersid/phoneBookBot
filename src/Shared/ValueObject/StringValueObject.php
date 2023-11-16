<?php
declare(strict_types=1);

namespace Sersid\Shared\ValueObject;

use Stringable;

abstract readonly class StringValueObject implements Stringable
{
    protected string $value;

    public function __construct(string $value = '')
    {
        $this->value = trim($value);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqual(self $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
