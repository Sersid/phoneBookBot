<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Domain\Contact\Event;

use Sersid\ContactBookBot\Domain\Category\Entity\Category;
use Sersid\ContactBookBot\Domain\Contact\Entity\Contact;

final readonly class ContactChangedCategoryEvent
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