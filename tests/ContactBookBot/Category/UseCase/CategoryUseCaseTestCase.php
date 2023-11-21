<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Category\UseCase;

use Sersid\ContactBookBot\Category\Domain\Entity\CategoryRepositoryInterface;
use Tests\ContactBookBot\UseCaseTestCase;

abstract class CategoryUseCaseTestCase extends UseCaseTestCase
{
    protected CategoryRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->get(CategoryRepositoryInterface::class);
    }
}