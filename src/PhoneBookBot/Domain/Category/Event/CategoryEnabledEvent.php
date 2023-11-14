<?php
declare(strict_types=1);

namespace Sersid\PhoneBookBot\Domain\Category\Event;

use Sersid\PhoneBookBot\Domain\Category\Entity\Category;
use Sersid\PhoneBookBot\Domain\Contact\Entity\Status;

final readonly class CategoryEnabledEvent
{
    public function __construct(private Category $category, private Status $oldStatus)
    {
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function getOldStatus(): Status
    {
        return $this->oldStatus;
    }
}