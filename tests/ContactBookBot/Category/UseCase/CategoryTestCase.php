<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Category\UseCase;

use PHPUnit\Framework\MockObject\MockObject;
use Sersid\ContactBookBot\Category\Domain\Entity\CategoryRepositoryInterface;
use Tests\ContactBookBot\Category\CategoryFixture;
use Tests\TestCase;

abstract class CategoryTestCase extends TestCase
{
    /**
     * @psalm-suppress PropertyNotSetInConstructor
     */
    protected MockObject $categoryRepository;

    /**
     * @psalm-suppress PropertyNotSetInConstructor
     */
    protected CategoryFixture $categoryFixture;

    protected function setUp(): void
    {
        parent::setUp();

        $this->categoryRepository = $this->createMock(CategoryRepositoryInterface::class);
        $this->container->set(CategoryRepositoryInterface::class,  $this->categoryRepository);

        $this->categoryFixture = new CategoryFixture();
    }
}