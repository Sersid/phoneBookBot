<?php

declare(strict_types=1);

namespace Tests;

use DI\Container;
use DI\ContainerBuilder;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase as PHPUnit_TestCase;
use Psr\EventDispatcher\EventDispatcherInterface;

abstract class TestCase extends PHPUnit_TestCase
{
    /** @psalm-suppress PropertyNotSetInConstructor */
    protected Container $container;

    /** @psalm-suppress PropertyNotSetInConstructor */
    protected MockObject $eventDispatcher;

    protected function setUp(): void
    {
        parent::setUp();

        $this->container = $this->getContainer();

        $this->eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $this->container->set(EventDispatcherInterface::class, $this->eventDispatcher);
    }

    private function getContainer(): Container
    {
        return (new ContainerBuilder())->build();
    }

    /**
     * @template T
     * @param class-string<T> $className
     *
     * @return T
     */
    protected function get(string $className): mixed
    {
        return $this->container->get($className);
    }
}
