<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Contact\UseCase;

use Psr\EventDispatcher\EventDispatcherInterface;
use Sersid\ContactBookBot\Category\UseCase\GetByUuid;
use Sersid\ContactBookBot\Contact\Domain\Entity\Contact;
use Sersid\ContactBookBot\Contact\Domain\Entity\ContactRepositoryInterface;
use Sersid\ContactBookBot\Contact\Domain\Entity\Name;
use Sersid\ContactBookBot\Contact\Domain\Event\ContactCreatedEvent;
use Sersid\Shared\ValueObject\Uuid;

final readonly class Create
{
    public function __construct(
        private GetByUuid $getByUuid,
        private ContactRepositoryInterface $repository,
        private EventDispatcherInterface $eventDispatcher,
    )
    {
    }

    public function handle(string $categoryUuid, string $name): void
    {
        $category = $this->getByUuid->handle($categoryUuid);
        $contact = new Contact(Uuid::next(), $category, new Name($name));

        $this->repository->add($contact);

        $this->eventDispatcher->dispatch(new ContactCreatedEvent($contact));
    }
}