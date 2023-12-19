<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Category;

use Sersid\ContactBookBot\Category\Domain\Entity\Category;
use Sersid\ContactBookBot\Category\Domain\Entity\CategoryBuilder;
use Sersid\ContactBookBot\Category\Domain\Entity\Name;
use Sersid\ContactBookBot\Category\Domain\Entity\Status;
use Sersid\Shared\ValueObject\Uuid;

final readonly class CategoryFixture
{
    private CategoryBuilder $categoryBuilder;

    public function __construct()
    {
        $this->categoryBuilder = (new CategoryBuilder())
            ->setUuid(Uuid::next())
            ->setName(new Name('Название категории'));
    }

    public function getDefault(): Category
    {
        return $this->categoryBuilder->build();
    }

    public function getWithUuid(Uuid $uuid): Category
    {
        return $this->categoryBuilder
            ->setUuid($uuid)
            ->build();
    }

    public function getWithName(Name $name): Category
    {
        return $this->categoryBuilder
            ->setName($name)
            ->build();
    }

    public function getTurnedOn(): Category
    {
        return $this->categoryBuilder
            ->setStatus(Status::TurnedOn)
            ->build();
    }

    public function getTurnedOff(): Category
    {
        return $this->categoryBuilder
            ->setStatus(Status::TurnedOff)
            ->build();
    }
}