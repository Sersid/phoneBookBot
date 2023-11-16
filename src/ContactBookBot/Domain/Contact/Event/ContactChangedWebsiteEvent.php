<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Domain\Contact\Event;

use Sersid\ContactBookBot\Domain\Contact\Entity\Contact;
use Sersid\ContactBookBot\Domain\Contact\Entity\Website;

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