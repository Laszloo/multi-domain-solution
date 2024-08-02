<?php

namespace App\Domain\Sites\TestShopOrg\Application\Service;

use App\Domain\Repository\BrandRepositoryInterface;
use App\Domain\Sites\TestShopOrg\Application\Contract\BrandServiceInterface;

class BrandService implements BrandServiceInterface
{
    public function __construct(
        private readonly BrandRepositoryInterface $brandRepository
    ){
    }

    public function getDummyExample(): array
    {
        $allActive = $this->brandRepository->findAllActive();

        return [
            "data" => $allActive,
            "example" => 'LOCAL DUMMY SERVICE',
            "dummy" => 'Hello world'
        ];
    }
}
