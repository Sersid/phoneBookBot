<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Category\Domain\Entity;

use DomainException;
use Sersid\Shared\ValueObject\Uuid;

final class Category
{
    public function __construct(
        private readonly Uuid $uuid,
        private Name $name,
        private Status $status = Status::TurnedOn
    ) {
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

    public function rename(Name $name): void
    {
        if ($this->name->isEqual($name)) {
            throw new DomainException('Название категории не изменилось');
        }

        $this->name = $name;
    }

    public function turnOff(): void
    {
        if ($this->status->isTurnedOff()) {
            throw new DomainException('Категория уже выключена');
        }

        $this->status = Status::TurnedOff;
    }

    public function turnOn(): void
    {
        if ($this->status->isTurnedOn()) {
            throw new DomainException('Категория уже включена');
        }

        $this->status = Status::TurnedOn;
    }
}