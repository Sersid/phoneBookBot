<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Contact\Domain\Event;

use Sersid\ContactBookBot\Contact\Domain\Entity\Address;
use Sersid\ContactBookBot\Contact\Domain\Entity\Contact;
use Sersid\Shared\Event;

final readonly class ContactChangedAddressEvent implements Event
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