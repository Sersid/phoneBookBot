<?php
declare(strict_types=1);

namespace Sersid\PhoneBookBot\Domain\Category\Entity;

use Sersid\Shared\ValueObject\StringValueObject;
use Webmozart\Assert\Assert;

final class Name extends StringValueObject
{
    public function __construct(string $value)
    {
        $value = trim($value);
        Assert::notEmpty($value, 'Название обязательно для заполнения');
        parent::__construct($value);
    }
}