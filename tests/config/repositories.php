<?php
declare(strict_types=1);

use Sersid\ContactBookBot\Category\Domain\Entity\CategoryRepositoryInterface;
use Sersid\ContactBookBot\Category\Infrastructure\InMemoryCategoryRepository;
use DI\ContainerBuilder;
use function DI\autowire;

return static function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        CategoryRepositoryInterface::class => autowire(InMemoryCategoryRepository::class),
    ]);
};