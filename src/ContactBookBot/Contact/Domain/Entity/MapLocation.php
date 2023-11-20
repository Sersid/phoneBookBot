<?php
declare(strict_types=1);

namespace Sersid\ContactBookBot\Contact\Domain\Entity;

use Webmozart\Assert\Assert;

final readonly class MapLocation
{
    public function __construct(private float|null $lat = null, private float|null $lon = null)
    {
        Assert::false($this->lat === null && $this->lon !== null, 'Широта обязательна для заполнения');
        Assert::false($this->lat !== null && $this->lon === null, 'Долгота обязательна для заполнения');
    }

    public function getLat(): float|null
    {
        return $this->lat;
    }

    public function getLon(): float|null
    {
        return $this->lon;
    }

    public function isEmpty(): bool
    {
        return $this->lat === null || $this->lon === null;
    }

    public function isEqual(self $other): bool
    {
        return $this->lat === $other->lat && $this->lon === $other->lon;
    }
}