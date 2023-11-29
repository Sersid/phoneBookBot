<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Contact\Domain\Entity;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Sersid\ContactBookBot\Contact\Domain\Entity\Status;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

#[CoversClass(Status::class)]
#[TestDox('Тесты статуса контакта')]
final class StatusTest extends TestCase
{
    public function testIsDraft(): void
    {
        $status = Status::Draft;

        assertTrue($status->isDraft());
        assertFalse($status->isPublished());
        assertFalse($status->isUnpublished());
    }

    public function testIsPublished(): void
    {
        $status = Status::Published;

        assertFalse($status->isDraft());
        assertTrue($status->isPublished());
        assertFalse($status->isUnpublished());
    }

    public function testIsUnpublished(): void
    {
        $status = Status::Unpublished;

        assertFalse($status->isDraft());
        assertFalse($status->isPublished());
        assertTrue($status->isUnpublished());
    }
}
