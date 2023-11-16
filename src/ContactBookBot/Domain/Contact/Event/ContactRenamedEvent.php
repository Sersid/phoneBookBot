<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Domain\Contact\Event;

use Sersid\ContactBookBot\Domain\Contact\Entity\Contact;
use Sersid\ContactBookBot\Domain\Contact\Entity\Name;

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