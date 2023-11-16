<?php
declare(strict_types=1);

namespace Tests\Shared\ValueObject;

use PHPUnit\Framework\Attributes\TestWith;
use Sersid\Shared\ValueObject\StringValueObject;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertSame;

#[CoversClass(StringValueObject::class)]
#[TestDox('Тесты StringValueObject')]
final class StringValueObjectTest extends TestCase
{

    #[TestDox('Тест определения пустого значения (value: "$value", expected: $expected)')]
    #[TestWith(['', true])]
    #[TestWith(['   ', true])]
    #[TestWith(['My value', false])]
    public function testIsEmpty(string $value, bool $expected): void
    {
        $stringValueObject = new ExampleStringValueObject($value);

        $result = $stringValueObject->isEmpty();

        assertSame($expected, $result);
    }
}
