<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Contact\Domain\Entity;

use Sersid\Shared\ValueObject\StringValueObject;
use Webmozart\Assert\Assert;

final readonly class Name extends StringValueObject
{
    public function __construct(string $value)
    {
        $value = trim($value);
        Assert::notEmpty($value, 'Название контакта обязательно для заполнения');
        parent::__construct($value);
    }
}