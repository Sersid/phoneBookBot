<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Category\Infrastructure;

use Sersid\ContactBookBot\Category\Domain\Entity\Categories;
use Sersid\ContactBookBot\Category\Domain\Entity\Category;
use Sersid\ContactBookBot\Category\Domain\Entity\CategoryRepositoryInterface;
use Sersid\ContactBookBot\Category\Domain\Entity\Name;
use Sersid\ContactBookBot\Category\Domain\Entity\Status;
use Sersid\Shared\ValueObject\Uuid;

final class InMemoryCategoryRepository implements CategoryRepositoryInterface
{
    public Categories $categories;

    public function __construct()
    {
        $this->categories = new Categories();
        $this->categories->add(new Category(Uuid::next(), new Name('Сантехник'), Status::TurnedOn));
        $this->categories->add(new Category(Uuid::next(), new Name('Управляющая компания')));
    }

    public function add(Category $category): void
    {
        $this->categories->add($category);
    }

    public function getAll(): Categories
    {
        return $this->categories;
    }
}