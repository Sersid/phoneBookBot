<?php
declare(strict_types=1);

namespace Sersid\PhoneBookBot\Domain\Contact\Entity;

use Sersid\Shared\ValueObject\StringValueObject;
use Webmozart\Assert\Assert;

final class Phone extends StringValueObject
{
    public function __construct(string $value)
    {
        $value = trim($value);
        Assert::notEmpty($value);
        parent::__construct($value);
    }
}