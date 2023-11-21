<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Category\Domain\Entity;

use Ramsey\Collection\AbstractCollection;

/**
 * @extends AbstractCollection<Category>
 */
final class Categories extends AbstractCollection
{
    public function getType(): string
    {
        return Category::class;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        parent::offsetSet($value->getUuid()->getValue(), $value);
    }
}