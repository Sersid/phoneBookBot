<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Contact\Domain\Event;

use Sersid\ContactBookBot\Category\Domain\Entity\Category;
use Sersid\ContactBookBot\Contact\Domain\Entity\Contact;
use Sersid\Shared\Event;

final readonly class ContactChangedCategoryEvent implements Event
{
    public function __construct(private Contact $contact, private Category $oldCategory)
    {
    }

    public function getContact(): Contact
    {
        return $this->contact;
    }

    public function getOldCategory(): Category
    {
        return $this->oldCategory;
    }
}