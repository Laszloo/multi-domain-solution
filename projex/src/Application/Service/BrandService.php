<?php

namespace App\Application\Service;

use App\Domain\Repository\BrandRepositoryInterface;
use App\Application\Contract\BrandServiceInterface;

class BrandService implements BrandServiceInterface
{
    public function __construct(
        private readonly BrandRepositoryInterface $brandRepository
    ){
    }

    public function getDummyExample(): array
    {
        $allActive = $this->brandRepository->findAllActive();

        return ["data" => $allActive, "example" => 'GLOBAL DUMMY SERVICE'];
    }
}
