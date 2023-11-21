<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Psr\EventDispatcher\EventDispatcherInterface;
use Tests\Event\EventDispatcher;
use function DI\autowire;

return static function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        EventDispatcherInterface::class => autowire(EventDispatcher::class),
    ]);
};