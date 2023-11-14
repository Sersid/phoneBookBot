<?php
declare(strict_types=1);

namespace Sersid\PhoneBookBot\Domain\Contact\Entity;

use Sersid\Shared\ValueObject\Uuid;

final readonly class Contact
{
    public function __construct(private Uuid $uuid, private Name $name, private Status $status = Status::Enable)
    {
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
}