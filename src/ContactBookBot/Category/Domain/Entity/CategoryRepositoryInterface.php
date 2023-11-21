<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Category\Domain\Entity;

use Sersid\ContactBookBot\Category\Domain\Exception\CategoryNotFoundException;
use Sersid\Shared\ValueObject\Uuid;

interface CategoryRepositoryInterface
{
    public function add(Category $category): void;

    public function getAll(): Categories;

    /**
     * @throws CategoryNotFoundException
     */
    public function getByUuid(Uuid $uuid): Category;
}