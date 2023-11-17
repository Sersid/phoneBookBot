<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Domain\Contact\Event;

use Sersid\ContactBookBot\Domain\Contact\Entity\Contact;
use Sersid\ContactBookBot\Domain\Contact\Entity\Phone;

final readonly class ContactPhoneAddedEvent
{
    public function __construct(private Contact $contact, private Phone $phone)
    {
    }

    public function getContact(): Contact
    {
        return $this->contact;
    }

    public function getPhone(): Phone
    {
        return $this->phone;
    }
}