<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Domain\Contact\Event;

use Sersid\ContactBookBot\Domain\Contact\Entity\Contact;

final readonly class ContactCreatedEvent
{
    public function __construct(private Contact $contact)
    {
    }

    public function getContact(): Contact
    {
        return $this->contact;
    }
}