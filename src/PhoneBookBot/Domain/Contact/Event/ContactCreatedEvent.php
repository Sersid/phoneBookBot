<?php
declare(strict_types=1);

namespace Sersid\PhoneBookBot\Domain\Contact\Event;

use Sersid\PhoneBookBot\Domain\Contact\Entity\Contact;

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