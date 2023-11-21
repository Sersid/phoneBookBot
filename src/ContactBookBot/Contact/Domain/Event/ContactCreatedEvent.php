<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Contact\Domain\Event;

use Sersid\ContactBookBot\Contact\Domain\Entity\Contact;
use Sersid\Shared\Event;

final readonly class ContactCreatedEvent implements Event
{
    public function __construct(private Contact $contact)
    {
    }

    public function getContact(): Contact
    {
        return $this->contact;
    }
}