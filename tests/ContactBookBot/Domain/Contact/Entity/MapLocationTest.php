<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Domain\Contact\Entity;

use PHPUnit\Framework\Attributes\TestWith;
use Sersid\ContactBookBot\Domain\Contact\Entity\MapLocation;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertTrue;

#[CoversClass(MapLocation::class)]
#[TestDox('Тесты расположения на карте')]
final class MapLocationTest extends TestCase
{
    #[TestDox('Тест возможности не указывать расположения на карте')]
    public function testIsEmpty(): void
    {
        $mapLocation = new MapLocation();

        $result = $mapLocation->isEmpty();

        assertTrue($result);
    }

    #[TestDox('Тест создания корректного расположения на карте (lat: $lat, lon: $lon, expected: $expectedMessage)')]
    #[TestWith([null, 39.20030152856972, 'Широта обязательна для заполнения'])]
    #[TestWith([51.66078810541489, null, 'Долгота обязательна для заполнения'])]
    public function testIncorrectCreate(float|null $lat, float|null $lon, string $expectedMessage): void
    {
        $this->expectExceptionMessage($expectedMessage);

        new MapLocation($lat, $lon);
    }
}
