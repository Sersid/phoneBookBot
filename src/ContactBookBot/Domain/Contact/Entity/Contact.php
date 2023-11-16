<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Domain\Contact\Entity;

use Sersid\ContactBookBot\Domain\Category\Entity\Category;
use Sersid\ContactBookBot\Domain\Contact\Event;
use Sersid\Shared\AggregateRoot;
use Sersid\Shared\EventTrait;
use Sersid\Shared\ValueObject\Uuid;

final class Contact implements AggregateRoot
{
    use EventTrait;
    public function __construct(
        private readonly Uuid $uuid,
        private Category $category,
        private Name $name = new Name(),
        private readonly array $phones = [],
        private Address $address = new Address(),
        private Website $website = new Website(),
        private readonly Status $status = Status::Draft
    ) {
        $this->recordEvent(new Event\ContactCreatedEvent($this));
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

    public function getPhones(): array
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

        $this->recordEvent(new Event\ContactChangedCategoryEvent($this, $this->category));
        $this->category = $category;
    }

    public function rename(Name $name): void
    {
        if ($this->name->isEqual($name)) {
            return;
        }

        $this->recordEvent(new Event\ContactRenamedEvent($this, $this->name));
        $this->name = $name;
    }

    public function changeAddress(Address $address): void
    {
        if ($this->address->isEqual($address)) {
            return;
        }

        $this->recordEvent(new Event\ContactChangedAddressEvent($this, $this->address));
        $this->address = $address;
    }

    public function changeWebsite(Website $website): void
    {
        if ($this->website->isEqual($website)) {
            return;
        }

        $this->recordEvent(new Event\ContactChangedWebsiteEvent($this, $this->website));
        $this->website = $website;
    }
}