<?php
declare(strict_types=1);

namespace Sersid\PhoneBookBot\Domain\Category\Event;

use Sersid\PhoneBookBot\Domain\Category\Entity\Category;
use Sersid\PhoneBookBot\Domain\Category\Entity\Name;

final readonly class CategoryRenamedEvent
{
    public function __construct(private Category $category, private Name $oldName)
    {
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function getOldName(): Name
    {
        return $this->oldName;
    }
}