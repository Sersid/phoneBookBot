<?php
declare(strict_types=1);

namespace Sersid\PhoneBookBot\Domain\Contact\Entity;

use Sersid\PhoneBookBot\Domain\Category\Entity\Category;
use Sersid\PhoneBookBot\Domain\Contact\Event;
use Sersid\Shared\AggregateRoot;
use Sersid\Shared\EventTrait;
use Sersid\Shared\ValueObject\Uuid;

final class Contact implements AggregateRoot
{
    use EventTrait;
    public function __construct(
        private readonly Uuid $uuid,
        private Category $category,
        private Name $name,
        private readonly array $phones = [],
        private readonly Address $address = new Address(),
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

    public function changeWebsite(Website $website): void
    {
        if ($this->website->isEqual($website)) {
            return;
        }

        $this->recordEvent(new Event\ContactChangedWebsiteEvent($this, $this->website));
        $this->website = $website;
    }
}