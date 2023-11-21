<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Category\UseCase;

use Psr\EventDispatcher\EventDispatcherInterface;
use Sersid\ContactBookBot\Category\Domain\Entity\Category;
use Sersid\ContactBookBot\Category\Domain\Entity\CategoryRepositoryInterface;
use Sersid\ContactBookBot\Category\Domain\Entity\Name;
use Sersid\ContactBookBot\Category\Domain\Event\CategoryCreatedEvent;
use Sersid\Shared\ValueObject\Uuid;

final readonly class Create
{
    public function __construct(
        private CategoryRepositoryInterface $repository,
        private EventDispatcherInterface $eventDispatcher,
    )
    {
    }

    public function handle(string $name): void
    {
        $category = new Category(Uuid::next(), new Name($name));

        $this->repository->add($category);

        $this->eventDispatcher->dispatch(new CategoryCreatedEvent($category));
    }
}