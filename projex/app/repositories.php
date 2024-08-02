<?php

declare(strict_types=1);

use App\Application\Injector\Container;
use App\Domain\User\UserRepository;
use App\Infrastructure\Persistence\User\InMemoryUserRepository;
use App\Infrastructure\Repository\BrandRepository;
use DI\ContainerBuilder;
use App\Domain\Repository\BrandRepositoryInterface;


return function (ContainerBuilder $containerBuilder, ?Container $container) {
    // Here we map our UserRepository interface to its in memory implementation
    $dependencies = [
        UserRepository::class => \DI\autowire(InMemoryUserRepository::class),
        BrandRepositoryInterface::class => \DI\autowire(BrandRepository::class)
    ];

    $containerBuilder->addDefinitions($container?->getDependencies($dependencies) ?? $dependencies);
};
