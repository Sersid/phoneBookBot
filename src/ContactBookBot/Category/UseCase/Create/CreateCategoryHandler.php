<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Category\UseCase\Create;

use Sersid\ContactBookBot\Category\Domain\Entity\Category;
use Sersid\ContactBookBot\Category\Domain\Entity\CategoryRepositoryInterface;
use Sersid\ContactBookBot\Category\Domain\Entity\Name;
use Sersid\Shared\ValueObject\Uuid;

final readonly class CreateCategoryHandler
{
    public function __construct(private CategoryRepositoryInterface $repository)
    {
    }

    public function handle(string $name): void
    {
        $category = new Category(Uuid::next(), new Name($name));

        $this->repository->add($category);
    }
}