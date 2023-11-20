<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Contact\Domain\Entity;

use PHPUnit\Framework\Attributes\TestWith;
use Sersid\ContactBookBot\Contact\Domain\Entity\Phone;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

#[CoversClass(Phone::class)]
#[TestDox('Тесты телефона')]
final class PhoneTest extends TestCase
{
    #[TestDox('Тест передачи пустого номера ("$number")')]
    #[TestWith([''])]
    #[TestWith(['   '])]
    public function testEmptyNumber(string $number): void
    {
        $this->expectExceptionMessage('Номер телефона обязателен для заполнения');

        new Phone($number);
    }

    #[TestDox('Тест создания телефона')]
    public function testCreate(): void
    {
        $number = '88005553535';
        $title = 'Диспетчер';

        $phone = new Phone($number, $title);

        assertSame($number, $phone->getNumber());
        assertSame($title, $phone->getTitle());
    }

    #[TestDox('Тест преобразования в строку (number: "$number", title: "$title", expected: "$expected")')]
    #[TestWith(['88005553535', 'Диспетчер', '88005553535 (Диспетчер)'])]
    #[TestWith(['88005553535', '', '88005553535'])]
    public function testToString(string $number, string $title, string $expected): void
    {
        $phone = new Phone($number, $title);

        assertSame($expected, (string)$phone);
    }

    #[TestDox('Тест эквивалентности двух телефонов')]
    public function testEqual(): void
    {
        $phone1 = new Phone('88005553535', 'Диспетчер');
        $phone2 = new Phone('88005553535', 'Диспетчер');

        $isEqual = $phone1->isEqual($phone2);

       assertTrue($isEqual);
    }

    #[TestDox('Тест не эквивалентности двух телефонов')]
    public function testNotEqual(): void
    {
        $phone1 = new Phone('88005553535', 'Диспетчер');
        $phone2 = new Phone('88005553535');

        $isEqual = $phone1->isEqual($phone2);

        assertFalse($isEqual);
    }

    #[TestDox('Тест получения "чистого" номера телефона (number: $number, expected: $expected)')]
    #[TestWith(['+78005553535', '78005553535'])]
    #[TestWith(['+7 (900) 123-45-67', '79001234567'])]
    public function testCleanPhone(string $number, string $expected): void
    {
        $number = new Phone($number);

        $result = $number->getCleanNumber();

        self::assertSame($expected, $result);
    }
}
