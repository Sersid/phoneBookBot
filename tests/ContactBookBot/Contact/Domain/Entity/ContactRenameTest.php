<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Contact\Domain\Entity;

use PHPUnit\Framework\Attributes\TestDox;
use Sersid\ContactBookBot\Contact\Domain\Entity\Name;
use function PHPUnit\Framework\assertSame;

#[TestDox('Тесты изменения названия контакта')]
final class ContactRenameTest extends ContactTestCase
{
    #[TestDox('Тест попытки переименовать контакт в то же имя')]
    public function testNoRename(): void
    {
        $newName = new Name('Диспетчер');

        $this->expectExceptionMessage('Название контакта не изменилось');

        self::$contact->rename($newName);
    }

    #[TestDox('Тест переименования контакта')]
    public function testRename(): void
    {
        $newName = new Name('Новое имя контакта');

        self::$contact->rename($newName);

        assertSame(self::$contact->getName(), $newName);
    }
}