<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Category\UseCase;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use Sersid\ContactBookBot\Category\Domain\Entity\Categories;
use Sersid\ContactBookBot\Category\UseCase\GetAll;
use function PHPUnit\Framework\assertSame;

#[CoversClass(GetAll::class)]
#[TestDox('Тест use case: получение всех категорий')]
final class GetAllTest extends CategoryTestCase
{
    public function test(): void
    {
        $categories = new Categories([
            $this->categoryFixture->getDefault(),
            $this->categoryFixture->getTurnedOn(),
        ]);

        $this->categoryRepository
            ->expects(self::once())
            ->method('getAll')
            ->willReturn($categories);

        $result = $this->get(GetAll::class)->handle();

        assertSame($categories, $result);
    }
}
