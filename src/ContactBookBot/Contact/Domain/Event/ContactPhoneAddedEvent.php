<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Contact\Domain\Event;

use Sersid\ContactBookBot\Contact\Domain\Entity\Contact;
use Sersid\ContactBookBot\Contact\Domain\Entity\Phone;
use Sersid\Shared\Event;

final readonly class ContactPhoneAddedEvent implements Event
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