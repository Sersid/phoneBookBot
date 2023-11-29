<?php
declare(strict_types=1);

namespace Tests\ContactBookBot\Category\Domain\Entity;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Sersid\ContactBookBot\Category\Domain\Entity\Status;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

#[CoversClass(Status::class)]
#[TestDox('Тесты статуса категории')]
final class StatusTest extends TestCase
{
    public function testIsTurnedOn(): void
    {
        $status = Status::TurnedOn;

        assertTrue($status->isTurnedOn());
        assertFalse($status->isTurnedOff());
    }

    public function testIsTurnedOff(): void
    {
        $status = Status::TurnedOff;

        assertFalse($status->isTurnedOn());
        assertTrue($status->isTurnedOff());
    }
}
