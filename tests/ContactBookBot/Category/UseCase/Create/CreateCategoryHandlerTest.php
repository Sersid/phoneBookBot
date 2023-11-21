<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Category\UseCase\Create;

use Sersid\ContactBookBot\Category\Domain\Entity\CategoryRepositoryInterface;
use Sersid\ContactBookBot\Category\UseCase\Create\CreateCategoryHandler;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use Tests\TestCase;
use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertSame;

#[CoversClass(CreateCategoryHandler::class)]
#[TestDox('Тест use case: создание категории')]
final class CreateCategoryHandlerTest extends TestCase
{
    private CategoryRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->get(CategoryRepositoryInterface::class);
    }

    public function test(): void
    {
        $name = 'Новая категория';
        $categories = $this->repository->getAll();
        $count = $categories->count();

        $this->get(CreateCategoryHandler::class)->handle($name);

        assertCount(++$count, $categories);
        assertSame($name, $categories->last()->getName()->getValue());
    }
}
