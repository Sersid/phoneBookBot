<?php
declare(strict_types=1);

namespace Tests\PhoneBookBot\Domain\Category\Entity;

use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\TestWith;
use Sersid\PhoneBookBot\Domain\Category\Entity\Name;
use PHPUnit\Framework\TestCase;

/**
 * @covers Name
 */
final class NameTest extends TestCase
{

    #[TestDox('Тест некорректного названия категории: "$value"')]
    #[TestWith([''])]
    #[TestWith([' '])]
    #[TestWith(['   '])]
    public function testEmptyValue(string $value): void
    {
        $this->expectExceptionMessage('Название обязательно для заполнения');

        new Name($value);
    }
}
