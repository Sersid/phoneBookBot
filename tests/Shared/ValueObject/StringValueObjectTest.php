<?php
declare(strict_types=1);

namespace Tests\Shared\ValueObject;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;
use Sersid\Shared\ValueObject\StringValueObject;
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
        $valueObject = new ExampleStringValueObject($value);

        $result = $valueObject->isEmpty();

        assertSame($expected, $result);
    }

    #[TestDox('Тест получения значения')]
    public function testGetValue(): void
    {
        $value = 'My value';

        $valueObject = new ExampleStringValueObject($value);

        assertSame($value, $valueObject->getValue());
    }

    #[TestDox('Тест эквивалентности объектов')]
    #[TestWith([ 'My value',  'My value', true])]
    #[TestWith([ 'My value',  'My not equal value', false])]
    public function testIsEqual(string $value1, string $value2, bool $expected): void
    {
        $valueObject1 = new ExampleStringValueObject($value1);
        $valueObject2 = new ExampleStringValueObject($value2);

        $result = $valueObject1->isEqual($valueObject2);

        assertSame($expected, $result);
    }

    #[TestDox('Тест __toString')]
    public function testToString(): void
    {
        $value = 'My value';

        $valueObject = new ExampleStringValueObject($value);

        assertSame($value, (string)$valueObject);
    }
}
