<?php
declare(strict_types=1);

namespace Sersid\PhoneBookBot\Domain\Contact\Event;

use Sersid\PhoneBookBot\Domain\Category\Entity\Category;
use Sersid\PhoneBookBot\Domain\Contact\Entity\Contact;

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