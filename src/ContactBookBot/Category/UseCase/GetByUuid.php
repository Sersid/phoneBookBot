<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Category\UseCase;

use Sersid\ContactBookBot\Category\Domain\Entity\Category;
use Sersid\ContactBookBot\Category\Domain\Entity\CategoryRepositoryInterface;
use Sersid\Shared\ValueObject\Uuid;

final readonly class GetByUuid
{
    public function __construct(private CategoryRepositoryInterface $repository)
    {
    }

    public function handle(string $uuid): Category
    {
        return $this->repository->getByUuid(new Uuid($uuid));
    }
}