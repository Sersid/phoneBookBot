<?php
declare(strict_types=1);

namespace Sersid\PhoneBookBot\Domain\Category\Entity;

enum Status
{
    case TurnedOn;
    case TurnedOff;

    public function isTurnedOn(): bool
    {
        return $this === self::TurnedOn;
    }

    public function isTurnedOff(): bool
    {
        return $this === self::TurnedOff;
    }
}