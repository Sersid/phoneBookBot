<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Contact\Domain\Entity;

use PHPUnit\Framework\Attributes\TestDox;
use Sersid\ContactBookBot\Contact\Domain\Entity\Address;
use function PHPUnit\Framework\assertSame;

#[TestDox('Тесты изменения адреса контакта')]
final class ContactChangeAddressTest extends ContactTestCase
{
    #[TestDox('Тест попытки изменить адрес без изменения содержимого адреса')]
    public function testNoChangeAddress(): void
    {
        $address = new Address();

        $this->expectExceptionMessage('Адрес контакта не изменился');

        self::$contact->changeAddress($address);
    }

    #[TestDox('Тест изменения адреса')]
    public function testChangeAddress(): void
    {
        $address = new Address('ул. Пушкина, 1');

        self::$contact->changeAddress($address);

        assertSame(self::$contact->getAddress(), $address);
    }
}