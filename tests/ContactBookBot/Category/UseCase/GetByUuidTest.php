<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Category\UseCase;

use Sersid\ContactBookBot\Category\Domain\Entity\Category;
use Sersid\ContactBookBot\Category\Domain\Entity\Name;
use Sersid\ContactBookBot\Category\UseCase\GetByUuid;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use Sersid\Shared\ValueObject\Uuid;

#[CoversClass(GetByUuid::class)]
#[TestDox('Тест use case: получение категории по uuid')]
final class GetByUuidTest extends CategoryTestCase
{
    public function test(): void
    {
        $uuid = '3fb7fe4b-77c6-4925-b958-f203c29adc34';

        $this->categoryRepository
            ->expects(self::once())
            ->method('getByUuid')
            ->with(self::equalTo(new Uuid($uuid)))
            ->willReturn(new Category(new Uuid($uuid), new Name('Управляющая компания')));

        $this->get(GetByUuid::class)->handle($uuid);
    }
}
