<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Category\Domain\Event;

use Sersid\ContactBookBot\Category\Domain\Entity\Category;

final readonly class CategoryCreatedEvent
{
    public function __construct(private Category $category)
    {
    }

    public function getCategory(): Category
    {
        return $this->category;
    }
}