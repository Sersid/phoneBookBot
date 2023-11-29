<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Contact\Domain\Entity;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;
use Sersid\ContactBookBot\Contact\Domain\Entity\Address;
use Sersid\ContactBookBot\Contact\Domain\Entity\MapLocation;
use function PHPUnit\Framework\assertSame;

#[CoversClass(Address::class)]
#[TestDox('Тесты адреса')]
final class AddressTest extends TestCase
{
    #[TestDox('Тест получения значений')]
    public function testGetAddress(): void
    {
        $addressValue = 'ул. Пушкина';
        $mapLocation = new MapLocation(51.6607, 39.2003);
        $address = new Address($addressValue, $mapLocation);

        assertSame($addressValue, $address->getAddress());
        assertSame($mapLocation, $address->getMapLocation());
    }

    #[TestDox('Тест заполнения')]
    #[TestWith([new Address(), true])]
    #[TestWith([new Address('  '), true])]
    #[TestWith([new Address('ул. Пушкина, 1'), false])]
    #[TestWith([new Address('', new MapLocation(51.6607, 39.2003)), false])]
    public function testIsEmpty(Address $address, bool $expected): void
    {
        $result = $address->isEmpty();

        assertSame($expected, $result);
    }

    #[TestDox('Тест эквивалентности')]
    #[TestWith([new Address(), new Address(), true])]
    #[TestWith([new Address(address: 'ул. Пушкина, 1'), new Address(address: 'ул. Пушкина, 1'), true])]
    #[TestWith([new Address(address: 'ул. Пушкина, 1'), new Address(), false])]
    #[TestWith([new Address(mapLocation: new MapLocation()), new Address(mapLocation: new MapLocation(51.6607, 39.2003)), false])]
    public function testIsEqual(Address $address1, Address $address2, bool $expected): void
    {
        $result = $address1->isEqual($address2);
        assertSame($expected, $result);
    }
}
