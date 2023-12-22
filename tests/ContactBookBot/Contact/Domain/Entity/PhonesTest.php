<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Contact\Domain\Entity;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Sersid\ContactBookBot\Contact\Domain\Entity\Phone;
use Sersid\ContactBookBot\Contact\Domain\Entity\Phones;
use function PHPUnit\Framework\assertSame;

#[CoversClass(Phones::class)]
#[TestDox('Тесты списка телефонов')]
final class PhonesTest extends TestCase
{
    #[TestDox('Тест попытки добавления существующего телефона')]
    public function testAddDuplicatePhone(): void
    {
        $phones = new Phones([
            new Phone('88005553535', 'Диспетчер'),
            new Phone('88005557575', 'Директор'),
        ]);

        $this->expectExceptionMessage('Номер телефона уже существует');

        $phones->addPhone(new Phone('8 800 555 35 35', 'Диспетчер'));
    }

    #[TestDox('Тест добавления телефона')]
    public function testAddPhone(): void
    {
        $phones = new Phones([
            new Phone('88005557575', 'Директор'),
        ]);
        $phone = new Phone('88005553535', 'Диспетчер');

        $phones->addPhone($phone);

        assertSame($phone, $phones[1]);
    }
}
