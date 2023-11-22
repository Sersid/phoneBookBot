<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Contact\UseCase;

use Psr\EventDispatcher\EventDispatcherInterface;
use Sersid\ContactBookBot\Category\UseCase\GetByUuid as GetCategoryByUuid;
use Sersid\ContactBookBot\Contact\Domain\Entity\ContactRepositoryInterface;
use Sersid\ContactBookBot\Contact\Domain\Event\ContactChangedCategoryEvent;

final readonly class ChangeCategory
{
    public function __construct(
        private GetByUuid $getContactByUuid,
        private GetCategoryByUuid $getCategoryByUuid,
        private ContactRepositoryInterface $repository,
        private EventDispatcherInterface $eventDispatcher,
    )
    {
    }

    public function handle(string $uuid, string $categoryUuid): void
    {
        $contact = $this->getContactByUuid->handle($uuid);
        $oldCategory = $contact->getCategory();
        $category = $this->getCategoryByUuid->handle($categoryUuid);
        $contact->changeCategory($category);

        $this->repository->update($contact);

        $this->eventDispatcher->dispatch(new ContactChangedCategoryEvent($contact, $oldCategory));
    }
}