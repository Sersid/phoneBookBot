<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Domain\Contact\Entity;

use LogicException;
use Sersid\ContactBookBot\Domain\Category\Entity\Category;
use Sersid\ContactBookBot\Domain\Contact\Event;
use Sersid\Shared\AggregateRoot;
use Sersid\Shared\ValueObject\Uuid;

final class Contact implements AggregateRoot
{
    public function __construct(
        private readonly Uuid $uuid,
        private Category $category,
        private Name $name,
        private readonly Phones $phones = new Phones(),
        private Address $address = new Address(),
        private Website $website = new Website(),
        private readonly Status $status = Status::Draft
    ) {
        Event\ContactEvent::recordEvent($this, 'created');
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getPhones(): Phones
    {
        return $this->phones;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function getWebsite(): Website
    {
        return $this->website;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function changeCategory(Category $category): void
    {
        if ($this->category->getUuid()->isEqual($category->getUuid())) {
            return;
        }

        Event\ContactEvent::recordEvent($this, 'changed-category', $this->category);
        $this->category = $category;
    }

    public function rename(Name $name): void
    {
        if ($this->name->isEqual($name)) {
            return;
        }

        Event\ContactEvent::recordEvent($this, 'renamed', $this->name);
        $this->name = $name;
    }

    public function addPhone(Phone $phone): void
    {
        $this->phones->addPhone($phone);
        Event\ContactEvent::recordEvent($this, 'phone-added', $phone);
    }

    public function removePhone(int $index): void
    {
        if (!isset($this->phones[$index])) {
            throw new LogicException('Телефон не найден');
        }

        Event\ContactEvent::recordEvent($this, 'phone-removed', $this->phones[$index]);
        unset($this->phones[$index]);
    }

    public function changeAddress(Address $address): void
    {
        if ($this->address->isEqual($address)) {
            return;
        }

        Event\ContactEvent::recordEvent($this, 'changed-address', $this->address);
        $this->address = $address;
    }

    public function changeWebsite(Website $website): void
    {
        if ($this->website->isEqual($website)) {
            return;
        }

        Event\ContactEvent::recordEvent($this, 'changed-website', $this->website);
        $this->website = $website;
    }

    public function releaseEvents(): array
    {
        return Event\ContactEvent::releaseEvents();
    }
}