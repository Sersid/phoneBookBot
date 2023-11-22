<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Contact\Domain\Entity;

use Stringable;
use Webmozart\Assert\Assert;

final readonly class Phone implements Stringable
{
    private string $number;
    private string $name;

    public function __construct(string $number, string $name = '')
    {
        $number = trim($number);
        Assert::notEmpty($number, 'Номер телефона обязателен для заполнения');
        $this->number = $number;

        $this->name = trim($name);
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function __toString(): string
    {
        return $this->number . (empty($this->name) ? '' : ' (' . $this->name . ')');
    }

    public function isEqual(self $other): bool
    {
        return (string)$this === (string)$other;
    }

    public function getCleanNumber(): string
    {
        return preg_replace('/\D/', '', $this->number);
    }
}