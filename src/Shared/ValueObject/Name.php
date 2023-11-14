<?php
declare(strict_types=1);

namespace Sersid\Shared\ValueObject;

use Webmozart\Assert\Assert;

abstract class Name extends StringValueObject
{
    public function __construct(string $value)
    {
        $value = trim($value);
        Assert::notEmpty($value, 'Название обязательно для заполнения');
        parent::__construct($value);
    }
}