<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Contact\Domain\Entity;

use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\Attributes\TestDox;
use Sersid\ContactBookBot\Contact\Domain\Entity\Phone;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

#[TestDox('Тесты изменения телефонов контакта')]
final class ContactChangePhonesTest extends ContactTestCase
{
    private static Phone $phone;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::$phone = new Phone('88005553535', 'Диспетчер');
    }

    #[TestDox('Тест добавления телефона')]
    public function testAddPhone(): void
    {
        self::$contact->releaseEvents();
        self::$contact->addPhone(self::$phone);

        self::assertSame(self::$phone, self::$phones[0]);
    }

    #[TestDox('Тест попытки добавления существующего телефона')]
    public function testAddDuplicatePhone(): void
    {
        $phone = new Phone('88005553535', 'Диспетчер');

        $this->expectExceptionMessage('Номер телефона уже существует');

        self::$contact->addPhone($phone);
    }

    #[TestDox('Тест удаления телефона')]
    public function testRemovePhone(): void
    {
        $phone = self::$contact->removePhone(0);

        assertTrue(self::$contact->getPhones()->isEmpty());
        assertSame(self::$phone, $phone);
    }

    #[TestDox('Тест попытки удаления несуществующего телефона')]
    #[Depends('testRemovePhone')]
    public function testRemoveUndefinedPhone(): void
    {
        $this->expectExceptionMessage('Телефон не найден');

        self::$contact->removePhone(100);
    }
}