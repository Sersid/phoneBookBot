<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Domain\Contact\Entity;

use PHPUnit\Framework\Attributes\TestWith;
use Sersid\ContactBookBot\Domain\Contact\Entity\MapLocation;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertSame;
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
    #[TestWith([null, 39.2003, 'Широта обязательна для заполнения'])]
    #[TestWith([51.6607, null, 'Долгота обязательна для заполнения'])]
    public function testIncorrectCreate(float|null $lat, float|null $lon, string $expectedMessage): void
    {
        $this->expectExceptionMessage($expectedMessage);

        new MapLocation($lat, $lon);
    }

    #[TestDox('Тест эквивалентности координат ([$lat1, $lon1], [$lat2, $lon2], expected: $expected)')]
    #[TestWith([null, null, null, null, true])]
    #[TestWith([51.6607, 39.2003, 51.6607, 39.2003, true])]
    #[TestWith([null, null, 51.6607, 39.2003, false])]
    #[TestWith([51.6608, 39.2003, 51.6607, 39.2003, false])]
    public function testIsEqual(float|null $lat1, float|null $lon1, float|null $lat2, float|null $lon2, bool $expected): void
    {
        $mapLocation1 = new MapLocation($lat1, $lon1);
        $mapLocation2 = new MapLocation($lat2, $lon2);

        $result = $mapLocation1->isEqual($mapLocation2);

        assertSame($expected, $result);
    }
}
