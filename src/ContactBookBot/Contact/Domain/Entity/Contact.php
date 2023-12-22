<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Contact\Domain\Entity;

use DomainException;
use LogicException;
use Sersid\ContactBookBot\Category\Domain\Entity\Category;
use Sersid\Shared\ValueObject\Uuid;

final class Contact
{
    public function __construct(
        private readonly Uuid $uuid,
        private Category $category,
        private Name $name,
        private readonly Phones $phones = new Phones(),
        private Address $address = new Address(),
        private Website $website = new Website(),
        private Status $status = Status::Draft
    ) {
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
            throw new DomainException('Категория не изменилась');
        }

        $this->category = $category;
    }

    public function rename(Name $name): void
    {
        if ($this->name->isEqual($name)) {
            throw new DomainException('Название контакта не изменилось');
        }

        $this->name = $name;
    }

    public function removePhone(int $index): Phone
    {
        if (!isset($this->phones[$index])) {
            throw new LogicException('Телефон не найден');
        }

        $phone = $this->phones[$index];
        unset($this->phones[$index]);

        return $phone;
    }

    public function changeAddress(Address $address): void
    {
        if ($this->address->isEqual($address)) {
            throw new DomainException('Адрес контакта не изменился');
        }

        $this->address = $address;
    }

    public function changeWebsite(Website $website): void
    {
        if ($this->website->isEqual($website)) {
            throw new DomainException('Вебсайта контакта не изменился');
        }

        $this->website = $website;
    }

    public function toDraft(): void
    {
        if ($this->status === Status::Draft) {
            throw new DomainException('Контакт уже перемещен в черновики');
        }

        $this->status = Status::Draft;
    }

    public function publish(): void
    {
        if ($this->status === Status::Published) {
            throw new DomainException('Контакт уже опубликован');
        }

        if ($this->phones->isEmpty() && $this->address->isEmpty() && $this->website->isEmpty()) {
            throw new DomainException('Необходимо указать контактную информацию');
        }

        $this->status = Status::Published;
    }

    public function unpublish(): void
    {
        if ($this->status === Status::Unpublished) {
            throw new DomainException('Контакт уже снят с публикации');
        }

        $this->status = Status::Unpublished;
    }
}