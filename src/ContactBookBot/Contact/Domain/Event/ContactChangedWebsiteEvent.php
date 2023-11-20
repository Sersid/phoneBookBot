<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Contact\Domain\Event;

use Sersid\ContactBookBot\Contact\Domain\Entity\Contact;
use Sersid\ContactBookBot\Contact\Domain\Entity\Website;

final readonly class ContactChangedWebsiteEvent
{
    public function __construct(private Contact $contact, private Website $oldWebsite)
    {
    }

    public function getContact(): Contact
    {
        return $this->contact;
    }

    public function getOldWebsite(): Website
    {
        return $this->oldWebsite;
    }
}