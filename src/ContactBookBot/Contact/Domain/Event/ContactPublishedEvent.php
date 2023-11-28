<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Contact\Domain\Event;

use Sersid\ContactBookBot\Contact\Domain\Entity\Contact;
use Sersid\ContactBookBot\Contact\Domain\Entity\Status;

final readonly class ContactPublishedEvent
{
    public function __construct(private Contact $contact, private  Status $oldStatus)
    {
    }

    public function getContact(): Contact
    {
        return $this->contact;
    }

    public function getOldStatus(): Status
    {
        return $this->oldStatus;
    }
}