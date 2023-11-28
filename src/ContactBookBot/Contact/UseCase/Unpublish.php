<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Contact\UseCase;

use Psr\EventDispatcher\EventDispatcherInterface;
use Sersid\ContactBookBot\Contact\Domain\Entity\ContactRepositoryInterface;
use Sersid\ContactBookBot\Contact\Domain\Event\ContactUnpublishedEvent;

final readonly class Unpublish
{
    public function __construct(
        private GetByUuid $getByUuid,
        private ContactRepositoryInterface $repository,
        private EventDispatcherInterface $eventDispatcher,
    )
    {
    }

    public function handle(string $uuid): void
    {
        $contact = $this->getByUuid->handle($uuid);
        $oldStatus = $contact->getStatus();
        $contact->unpublish();

        $this->repository->update($contact);

        $this->eventDispatcher->dispatch(new ContactUnpublishedEvent($contact, $oldStatus));
    }
}