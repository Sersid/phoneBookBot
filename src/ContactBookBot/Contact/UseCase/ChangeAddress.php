<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Contact\UseCase;

use Psr\EventDispatcher\EventDispatcherInterface;
use Sersid\ContactBookBot\Contact\Domain\Entity\Address;
use Sersid\ContactBookBot\Contact\Domain\Entity\ContactRepositoryInterface;
use Sersid\ContactBookBot\Contact\Domain\Entity\MapLocation;
use Sersid\ContactBookBot\Contact\Domain\Event\ContactChangedAddressEvent;

final readonly class ChangeAddress
{
    public function __construct(
        private GetByUuid $getByUuid,
        private ContactRepositoryInterface $repository,
        private EventDispatcherInterface $eventDispatcher,
    )
    {
    }
    public function handle(string $uuid, string $address, float|null $lat, float|null $lon): void
    {
        $contact = $this->getByUuid->handle($uuid);
        $oldAddress = $contact->getAddress();
        $contact->changeAddress(new Address($address, new MapLocation($lat, $lon)));

        $this->repository->update($contact);

        $this->eventDispatcher->dispatch(new ContactChangedAddressEvent($contact, $oldAddress));
    }
}