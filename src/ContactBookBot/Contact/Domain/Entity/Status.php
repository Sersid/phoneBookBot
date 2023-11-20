<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Contact\Domain\Entity;

enum Status
{
    case Draft;
    case Published;
    case Unpublished;

    public function isDraft(): bool
    {
        return $this === self::Draft;
    }

    public function isPublished(): bool
    {
        return $this === self::Published;
    }

    public function isUnpublished(): bool
    {
        return $this === self::Unpublished;
    }
}