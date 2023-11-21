<?php
declare(strict_types=1);

namespace Tests\ContactBookBot;

use Psr\EventDispatcher\EventDispatcherInterface;
use Tests\Event\EventDispatcher;
use Tests\TestCase;

abstract class UseCaseTestCase extends TestCase
{
    protected EventDispatcher $eventDispatcher;

    protected function setUp(): void
    {
        parent::setUp();
        $this->eventDispatcher = $this->get(EventDispatcherInterface::class);
    }
}