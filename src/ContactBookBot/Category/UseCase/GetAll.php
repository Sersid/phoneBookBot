<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Category\UseCase;

use Sersid\ContactBookBot\Category\Domain\Entity\Categories;
use Sersid\ContactBookBot\Category\Domain\Entity\CategoryRepositoryInterface;

final readonly class GetAll
{
    public function __construct(private CategoryRepositoryInterface $repository)
    {
    }

    public function handle(): Categories
    {
        return $this->repository->getAll();
    }
}