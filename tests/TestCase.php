<?php

declare(strict_types=1);

namespace Tests;

use DI\ContainerBuilder;
use PHPUnit\Framework\TestCase as PHPUnit_TestCase;
use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Factory\AppFactory;

abstract class TestCase extends PHPUnit_TestCase
{
    private ContainerInterface|null $container = null;
    private App|null $app = null;

    protected function getContainer(): ContainerInterface
    {
        if ($this->container === null) {
            // Instantiate PHP-DI ContainerBuilder
            $containerBuilder = new ContainerBuilder();

            // Container intentionally not compiled for tests.

            // Set up dependencies
            $dependencies = require __DIR__ . '/config/dependencies.php';
            $dependencies($containerBuilder);

            // Set up repositories
            $repositories = require __DIR__ . '/config/repositories.php';
            $repositories($containerBuilder);

            // Build PHP-DI Container instance
            $this->container = $containerBuilder->build();
        }

        return $this->container;
    }

    protected function getAppInstance(): App
    {
        if ($this->app === null) {
            AppFactory::setContainer($this->getContainer());
            $this->app = AppFactory::create();
        }

        return $this->app;
    }

    /**
     * @template T
     * @param class-string<T> $className
     *
     * @return T
     */
    protected function get(string $className): mixed
    {
        $object = $this->getContainer()->get($className);
        if (!$object instanceof $className) {
            throw new \RuntimeException($className . ' cannot get');
        }

        return $object;
    }
}
