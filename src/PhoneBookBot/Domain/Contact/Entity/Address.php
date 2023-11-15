<?php
declare(strict_types=1);

namespace Sersid\PhoneBookBot\Domain\Contact\Entity;

final readonly class Address
{
    public function __construct(private string $street = '', private string $houseNumber = '', )
    {
        // coordinates
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getHouseNumber(): string
    {
        return $this->houseNumber;
    }
}