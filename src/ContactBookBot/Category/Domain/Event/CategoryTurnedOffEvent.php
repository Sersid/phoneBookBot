<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Category\Domain\Event;

use Sersid\ContactBookBot\Category\Domain\Entity\Category;
use Sersid\ContactBookBot\Category\Domain\Entity\Status;
use Sersid\Shared\Event;

final readonly class CategoryTurnedOffEvent implements Event
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