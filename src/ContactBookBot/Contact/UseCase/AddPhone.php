<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Contact\UseCase;

use Psr\EventDispatcher\EventDispatcherInterface;
use Sersid\ContactBookBot\Contact\Domain\Entity\ContactRepositoryInterface;
use Sersid\ContactBookBot\Contact\Domain\Entity\Phone;
use Sersid\ContactBookBot\Contact\Domain\Event\ContactPhoneAddedEvent;

final readonly class AddPhone
{
    public function __construct(
        private GetByUuid $getByUuid,
        private ContactRepositoryInterface $repository,
        private EventDispatcherInterface $eventDispatcher,
    )
    {
    }

    public function handle(string $uuid, string $phoneName, string $phoneNumber): void
    {
        $contact = $this->getByUuid->handle($uuid);
        $phone = new Phone($phoneNumber, $phoneName);
        $contact->addPhone($phone);

        $this->repository->update($contact);

        $this->eventDispatcher->dispatch(new ContactPhoneAddedEvent($contact, $phone));
    }
}