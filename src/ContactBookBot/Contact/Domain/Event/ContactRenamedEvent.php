<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Contact\Domain\Event;

use Sersid\ContactBookBot\Contact\Domain\Entity\Contact;
use Sersid\ContactBookBot\Contact\Domain\Entity\Name;

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