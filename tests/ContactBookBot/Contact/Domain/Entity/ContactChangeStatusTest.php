<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Contact\Domain\Entity;

use PHPUnit\Framework\Attributes\TestDox;

#[TestDox('Тесты изменения телефонов контакта')]
final class ContactChangeStatusTest extends ContactTestCase
{
    #[TestDox('Тест попытки опубликовать контакт без контактных данных')]
    public function testPublishEmptyContact(): void
    {
        $this->expectExceptionMessage('Необходимо указать контактную информацию');

        self::$contact->publish();
    }
}