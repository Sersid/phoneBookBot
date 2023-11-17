<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Domain\Contact\Entity;

use Stringable;
use Webmozart\Assert\Assert;

final readonly class Phone implements Stringable
{
    private string $title;
    private string $number;

    public function __construct(string $number, string $title = '')
    {
        $number = trim($number);
        Assert::notEmpty($number, 'Номер телефона обязателен для заполнения');
        $this->number = $number;

        $this->title = trim($title);
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function __toString(): string
    {
        return $this->number . (empty($this->title) ? '' : ' (' . $this->title . ')');
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