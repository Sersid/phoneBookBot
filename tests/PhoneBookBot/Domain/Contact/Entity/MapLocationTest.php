<?php
declare(strict_types=1);

namespace Tests\PhoneBookBot\Domain\Contact\Entity;

use PHPUnit\Framework\Attributes\TestWith;
use Sersid\PhoneBookBot\Domain\Contact\Entity\MapLocation;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertTrue;

#[CoversClass(MapLocation::class)]
#[TestDox('Тесты расположения на карте')]
final class MapLocationTest extends TestCase
{
    #[TestDox('Проверка отсутствия данных')]
    public function testIsEmpty(): void
    {
        $mapLocation = new MapLocation();

        $result = $mapLocation->isEmpty();

        assertTrue($result);
    }

    #[TestDox('Тест создания некорректного расположения на карте (lat: $lat, lon: $lon, expected: $expectedMessage)')]
    #[TestWith([null, 39.20030152856972, 'Широта обязательна для заполнения'])]
    #[TestWith([51.66078810541489, null, 'Долгота обязательна для заполнения'])]
    public function testIncorrectCreate(float|null $lat, float|null $lon, string $expectedMessage): void
    {
        $this->expectExceptionMessage($expectedMessage);

        new MapLocation($lat, $lon);
    }
}
