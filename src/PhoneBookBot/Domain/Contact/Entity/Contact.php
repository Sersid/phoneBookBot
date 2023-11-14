<?php
declare(strict_types=1);

namespace Sersid\PhoneBookBot\Domain\Contact\Entity;

use Sersid\PhoneBookBot\Domain\Contact\Event\ContactCreatedEvent;
use Sersid\Shared\AggregateRoot;
use Sersid\Shared\EventTrait;
use Sersid\Shared\ValueObject\Uuid;

final class Contact implements AggregateRoot
{
    use EventTrait;
    public function __construct(private readonly Uuid $uuid, private readonly Name $name, private readonly Status $status = Status::Enable)
    {
        $this->recordEvent(new ContactCreatedEvent($this));
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }
}