<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Category\Domain\Entity;

use Sersid\ContactBookBot\Category\Domain\Exception\CategoryNotFoundException;
use Sersid\Shared\ValueObject\Uuid;

interface CategoryRepositoryInterface
{
    public function add(Category $category): void;

    public function update(Category $category): void;

    /**
     * @throws CategoryNotFoundException
     */
    public function getByUuid(Uuid $uuid): Category;

    public function getAll(): Categories;
}