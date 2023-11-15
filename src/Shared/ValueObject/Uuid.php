<?php
declare(strict_types=1);

namespace Sersid\Shared\ValueObject;

use Webmozart\Assert\Assert;

final readonly class Uuid extends StringValueObject
{
    public function __construct(string $value)
    {
        Assert::uuid($value);
        parent::__construct($value);
    }

    public static function next(): self
    {
        return new self(\Ramsey\Uuid\Uuid::uuid4()->toString());
    }
}
