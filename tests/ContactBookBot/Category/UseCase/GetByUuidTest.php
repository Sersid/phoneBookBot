<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Category\UseCase;

use Sersid\ContactBookBot\Category\Domain\Exception\CategoryNotFoundException;
use Sersid\ContactBookBot\Category\UseCase\GetByUuid;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertSame;

#[CoversClass(GetByUuid::class)]
#[TestDox('Тест use case: получение категории по uuid')]
final class GetByUuidTest extends CategoryUseCaseTestCase
{
    #[TestDox('Успешное получение')]
    public function testSuccess(): void
    {
        $uuid = '3fb7fe4b-77c6-4925-b958-f203c29adc34';

        $category = $this->get(GetByUuid::class)->handle($uuid);

        assertSame($uuid, $category->getUuid()->getValue());
    }

    #[TestDox('Категории не существует')]
    public function testNotFound(): void
    {
        $uuid = 'e7b5e189-339d-46f3-9994-e04f3915d902'; // unknown uuid

        $this->expectException(CategoryNotFoundException::class);

        $this->get(GetByUuid::class)->handle($uuid);
    }
}
