<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Domain\Category\Event;

use Sersid\ContactBookBot\Domain\Category\Entity\Category;
use Sersid\ContactBookBot\Domain\Category\Entity\Status;

final readonly class CategoryTurnedOnEvent
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