<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Category\Domain\Event;

use Sersid\ContactBookBot\Category\Domain\Entity\Category;
use Sersid\ContactBookBot\Category\Domain\Entity\Name;
use Sersid\Shared\Event;

final readonly class CategoryRenamedEvent implements Event
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