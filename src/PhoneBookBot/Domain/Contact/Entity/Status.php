<?php
declare(strict_types=1);

namespace Sersid\PhoneBookBot\Domain\Contact\Entity;

enum Status
{
    case Enable;
    case Disable;

    public function isEnable(): bool
    {
        return $this === self::Enable;
    }

    public function isDisable(): bool
    {
        return $this === self::Disable;
    }
}