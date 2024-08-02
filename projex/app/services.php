<?php

declare(strict_types=1);

use App\Application\Injector\Container;
use App\Application\Contract\BrandServiceInterface;
use App\Application\Service\BrandService;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder, ?Container $container) {
    $dependencies = [
        BrandServiceInterface::class => \DI\autowire(BrandService::class),
    ];

    $containerBuilder->addDefinitions($container?->getDependencies($dependencies) ?? $dependencies);
};
