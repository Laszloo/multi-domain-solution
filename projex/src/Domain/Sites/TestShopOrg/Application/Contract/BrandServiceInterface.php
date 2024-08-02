<?php

namespace App\Domain\Sites\TestShopOrg\Application\Contract;

use App\Domain\Entity\Brand;

interface BrandServiceInterface
{
    /**
     * @return array{data: Brand[], example: string, dummy: string}
     */
    public function getDummyExample(): array;
}
