<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Category\Infrastructure;

use Sersid\ContactBookBot\Category\Domain\Entity\Categories;
use Sersid\ContactBookBot\Category\Domain\Entity\Category;
use Sersid\ContactBookBot\Category\Domain\Entity\CategoryRepositoryInterface;
use Sersid\ContactBookBot\Category\Domain\Entity\Name;
use Sersid\ContactBookBot\Category\Domain\Entity\Status;
use Sersid\ContactBookBot\Category\Domain\Exception\CategoryNotFoundException;
use Sersid\Shared\ValueObject\Uuid;

final class InMemoryCategoryRepository implements CategoryRepositoryInterface
{
    public Categories $categories;

    public function __construct()
    {
        $this->categories = new Categories([
            new Category(
                new Uuid('3fb7fe4b-77c6-4925-b958-f203c29adc34'),
                new Name('Сантехники'),
                Status::TurnedOn,
            ),
            new Category(
                new Uuid('36a7d6f8-5bd8-4e92-b694-88aa1bce9e7b'),
                new Name('Управляющая компания')
            ),
        ]);
    }

    public function add(Category $category): void
    {
        $this->categories->add($category);
    }

    public function getAll(): Categories
    {
        return $this->categories;
    }

    public function getByUuid(Uuid $uuid): Category
    {
        if (!isset($this->categories[$uuid->getValue()])) {
            throw new CategoryNotFoundException();
        }

        return $this->categories[$uuid->getValue()];
    }
}