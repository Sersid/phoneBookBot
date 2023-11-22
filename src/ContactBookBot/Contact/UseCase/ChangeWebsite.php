<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Contact\UseCase;

use Psr\EventDispatcher\EventDispatcherInterface;
use Sersid\ContactBookBot\Contact\Domain\Entity\ContactRepositoryInterface;
use Sersid\ContactBookBot\Contact\Domain\Entity\Website;
use Sersid\ContactBookBot\Contact\Domain\Event\ContactChangedWebsiteEvent;

final readonly class ChangeWebsite
{
    public function __construct(
        private GetByUuid $getByUuid,
        private ContactRepositoryInterface $repository,
        private EventDispatcherInterface $eventDispatcher,
    )
    {
    }

    public function handle(string $uuid, string $website): void
    {
        $contact = $this->getByUuid->handle($uuid);
        $oldWebsite = $contact->getWebsite();
        $contact->changeWebsite(new Website($website));

        $this->repository->update($contact);

        $this->eventDispatcher->dispatch(new ContactChangedWebsiteEvent($contact, $oldWebsite));
    }
}