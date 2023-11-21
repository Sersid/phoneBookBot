<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Category\UseCase;

use Psr\EventDispatcher\EventDispatcherInterface;
use Sersid\ContactBookBot\Category\Domain\Entity\CategoryRepositoryInterface;
use Sersid\ContactBookBot\Category\Domain\Entity\Name;
use Sersid\ContactBookBot\Category\Domain\Event\CategoryRenamedEvent;

final readonly class Rename
{
    public function __construct(
        private GetByUuid $getByUuid,
        private CategoryRepositoryInterface $repository,
        private EventDispatcherInterface $eventDispatcher,
    )
    {
    }

    public function handle(string $uuid, string $name): void
    {
        $category = $this->getByUuid->handle($uuid);
        $oldName = $category->getName();
        $category->rename(new Name($name));

        $this->repository->update($category);

        $this->eventDispatcher->dispatch(new CategoryRenamedEvent($category, $oldName));
    }
}