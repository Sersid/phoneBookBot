<?php
declare(strict_types=1);

namespace Tests\Shared\ValueObject;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Sersid\Shared\ValueObject\Uuid;
use function PHPUnit\Framework\assertNotEmpty;
use function PHPUnit\Framework\assertSame;

#[CoversClass(Uuid::class)]
#[TestDox('Тесты uuid')]
final class UuidTest extends TestCase
{
    public function testCreate(): void
    {
        $uuid = 'e3843942-f1c4-4190-bcba-cb2d871b66cc';

        $result = new Uuid($uuid);

        assertSame($uuid, $result->getValue());
    }

    public function testIncorrect(): void
    {
        $uuid = 'incorrect-uuid';

        $this->expectExceptionMessage('Некорректный uuid');

        new Uuid($uuid);
    }

    public function testNext(): void
    {
        $uuid = Uuid::next();

        assertNotEmpty($uuid->getValue());
    }
}
