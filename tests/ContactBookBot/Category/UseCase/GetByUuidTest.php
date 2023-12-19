<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Category\UseCase;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use Sersid\ContactBookBot\Category\UseCase\GetByUuid;
use Sersid\Shared\ValueObject\Uuid;
use function PHPUnit\Framework\assertSame;

#[CoversClass(GetByUuid::class)]
#[TestDox('Тест use case: получение категории по uuid')]
final class GetByUuidTest extends CategoryTestCase
{
    public function test(): void
    {
        $uuid = '3fb7fe4b-77c6-4925-b958-f203c29adc34';
        $category = $this->categoryFixture->getWithUuid(new Uuid($uuid));

        $this->categoryRepository
            ->expects(self::once())
            ->method('getByUuid')
            ->with(self::equalTo($category->getUuid()))
            ->willReturn($category);

        $result = $this->get(GetByUuid::class)->handle($uuid);

        assertSame($category, $result);
    }
}
