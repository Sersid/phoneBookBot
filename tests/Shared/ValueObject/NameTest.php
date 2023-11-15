<?php
declare(strict_types=1);

namespace Tests\Shared\ValueObject;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\TestWith;
use Sersid\Shared\ValueObject\Name;
use PHPUnit\Framework\TestCase;

#[CoversClass(Name::class)]
#[TestDox('Тесты названия')]
final class NameTest extends TestCase
{
    #[TestDox('Тест некорректного названия категории: "$value"')]
    #[TestWith([''])]
    #[TestWith([' '])]
    #[TestWith(['   '])]
    public function testEmptyValue(string $value): void
    {
        $this->expectExceptionMessage('Название обязательно для заполнения');

        new \Sersid\PhoneBookBot\Domain\Category\Entity\Name($value);
    }
}
