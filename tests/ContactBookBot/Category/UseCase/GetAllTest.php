<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Category\UseCase;

use Sersid\ContactBookBot\Category\Domain\Entity\Categories;
use Sersid\ContactBookBot\Category\UseCase\GetAll;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;

#[CoversClass(GetAll::class)]
#[TestDox('Тест use case: получение всех категорий')]
final class GetAllTest extends CategoryTestCase
{
    public function test(): void
    {
        $this->categoryRepository
            ->expects(self::once())
            ->method('getAll')
            ->willReturn(new Categories());

        $this->get(GetAll::class)->handle();
    }
}
