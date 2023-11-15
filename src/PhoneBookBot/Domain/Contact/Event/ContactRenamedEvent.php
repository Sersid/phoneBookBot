<?php
declare(strict_types=1);

namespace Sersid\PhoneBookBot\Domain\Contact\Event;

use Sersid\PhoneBookBot\Domain\Contact\Entity\Contact;
use Sersid\PhoneBookBot\Domain\Contact\Entity\Name;

final readonly class ContactRenamedEvent
{
    public function __construct(private Contact $contact, private Name $oldName)
    {
    }

    public function getContact(): Contact
    {
        return $this->contact;
    }

    public function getOldName(): Name
    {
        return $this->oldName;
    }
}