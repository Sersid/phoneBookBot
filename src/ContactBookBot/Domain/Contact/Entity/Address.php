<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Domain\Contact\Entity;

final readonly class Address
{
    private string $address;
    public function __construct(string $address = '', private MapLocation $mapLocation = new MapLocation())
    {
        $this->address = trim($address);
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getMapLocation(): MapLocation
    {
        return $this->mapLocation;
    }

    public function isEmpty(): bool
    {
        return empty($this->address) && $this->mapLocation->isEmpty();
    }

    public function isEqual(self $other): bool
    {
        return $this->address === $other->address && $this->mapLocation->isEqual($other->mapLocation);
    }
}