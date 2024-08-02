<?php

declare(strict_types=1);

use App\Application\Injector\Container;
use App\Domain\Sites\TestShopOrg\Application\Contract\BrandServiceInterface;
use App\Domain\Sites\TestShopOrg\Application\Service\BrandService;

return (function (): Container {
    $dependencies = [
        BrandServiceInterface::class => \DI\autowire(BrandService::class)
    ];

    return new Container($dependencies);
})();
