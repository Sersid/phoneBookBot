<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Domain\Contact\Entity;

final readonly class Address
{
    public function __construct(
        private string $address = '',
        private MapLocation $mapLocation = new MapLocation(),
    )
    {
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getMapLocation(): MapLocation
    {
        return $this->mapLocation;
    }
}