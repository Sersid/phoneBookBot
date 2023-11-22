<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Contact\UseCase;

use PHPUnit\Framework\MockObject\MockObject;
use Sersid\ContactBookBot\Contact\Domain\Entity\ContactRepositoryInterface;
use Tests\ContactBookBot\Category\UseCase\CategoryTestCase;

abstract class ContactUseCase extends CategoryTestCase
{
    /**
     * @psalm-suppress PropertyNotSetInConstructor
     */
    protected MockObject $contactRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->contactRepository = $this->createMock(ContactRepositoryInterface::class);
        $this->container->set(ContactRepositoryInterface::class,  $this->contactRepository);
    }
}