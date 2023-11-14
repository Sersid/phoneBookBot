<?php
declare(strict_types=1);

namespace Sersid\PhoneBookBot\Domain\Category\Entity;

use Sersid\PhoneBookBot\Domain\Category\Event;
use Sersid\Shared\AggregateRoot;
use Sersid\Shared\EventTrait;
use Sersid\Shared\ValueObject\Uuid;

final class Category implements AggregateRoot
{
    use EventTrait;

    public function __construct(
        private readonly Uuid $uuid,
        private Name $name,
        private Status $status = Status::Enable
    ) {
        $this->recordEvent(new Event\CategoryCreatedEvent($this));
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function isEnable(): bool
    {
        return $this->status->isEnable();
    }

    public function isDisable(): bool
    {
        return $this->status->isDisable();
    }

    public function rename(Name $name): void
    {
        if ($this->name->isEqual($name)) {
            return;
        }

        $this->recordEvent(new Event\CategoryRenamedEvent($this, $this->name));
        $this->name = $name;
    }

    public function disable(): void
    {
        if ($this->status === Status::Disable) {
            return;
        }

        $this->recordEvent(new Event\CategoryDisabledEvent($this, $this->status));
        $this->status = Status::Disable;
    }

    public function enable(): void
    {
        if ($this->status === Status::Enable) {
            return;
        }

        $this->recordEvent(new Event\CategoryEnabledEvent($this, $this->status));
        $this->status = Status::Enable;
    }
}