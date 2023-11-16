<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Domain\Contact\Event;

use Sersid\ContactBookBot\Domain\Contact\Entity\Address;
use Sersid\ContactBookBot\Domain\Contact\Entity\Contact;

final readonly class ContactChangedAddressEvent
{
    public function __construct(private Contact $contact, private Address $oldAddress)
    {
    }

    public function getContact(): Contact
    {
        return $this->contact;
    }

    public function getOldAddress(): Address
    {
        return $this->oldAddress;
    }
}