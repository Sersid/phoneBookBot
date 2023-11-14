<?php
declare(strict_types=1);

namespace Sersid\PhoneBookBot\Domain\Category\Event;

use Sersid\PhoneBookBot\Domain\Category\Entity\Category;

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