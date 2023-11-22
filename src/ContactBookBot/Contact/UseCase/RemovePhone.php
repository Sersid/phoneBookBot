<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Contact\UseCase;

use Psr\EventDispatcher\EventDispatcherInterface;
use Sersid\ContactBookBot\Contact\Domain\Entity\ContactRepositoryInterface;
use Sersid\ContactBookBot\Contact\Domain\Event\ContactPhoneRemovedEvent;

final readonly class RemovePhone
{
    public function __construct(
        private GetByUuid $getByUuid,
        private ContactRepositoryInterface $repository,
        private EventDispatcherInterface $eventDispatcher,
    )
    {
    }

    public function handle(string $uuid, int $index): void
    {
        $contact = $this->getByUuid->handle($uuid);
        $phone = $contact->removePhone($index);

        $this->repository->update($contact);

        $this->eventDispatcher->dispatch(new ContactPhoneRemovedEvent($contact, $phone));
    }
}