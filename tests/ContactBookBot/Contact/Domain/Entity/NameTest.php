<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Contact\Domain\Entity;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;
use Sersid\ContactBookBot\Contact\Domain\Entity\Name;
use function PHPUnit\Framework\assertSame;

#[CoversClass(Name::class)]
#[TestDox('Тесты названия контакта')]
final class NameTest extends TestCase
{
    #[TestDox('Тест некорректного названия контакта: "$value"')]
    #[TestWith([''])]
    #[TestWith(['   '])]
    public function testEmptyValue(string $value): void
    {
        $this->expectExceptionMessage('Название контакта обязательно для заполнения');

        new Name($value);
    }

    public function testCreate(): void
    {
        $name = 'Название контакта';

        $result = new Name($name);

        assertSame($name, $result->getValue());
    }
}
