<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Category\Domain\Entity;

interface CategoryRepositoryInterface
{
    public function add(Category $category): void;

    public function getAll(): Categories;
}