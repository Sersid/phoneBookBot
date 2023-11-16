<?php
declare(strict_types=1);

namespace Sersid\PhoneBookBot\Domain\Contact\Entity;

enum Status
{
    case Draft;
    case Published;
    case Removed;

    public function isDraft(): bool
    {
        return $this === self::Draft;
    }

    public function isPublished(): bool
    {
        return $this === self::Published;
    }

    public function isRemoved(): bool
    {
        return $this === self::Removed;
    }
}