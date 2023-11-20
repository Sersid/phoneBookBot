<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Category\Domain\Entity;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;
use Sersid\ContactBookBot\Category\Domain\Entity\Name;

#[CoversClass(Name::class)]
#[TestDox('Тесты названия категории')]
final class NameTest extends TestCase
{
    #[TestDox('Тест некорректного названия категории: "$value"')]
    #[TestWith([''])]
    #[TestWith(['   '])]
    public function testEmptyValue(string $value): void
    {
        $this->expectExceptionMessage('Название обязательно для заполнения');

        new Name($value);
    }
}
