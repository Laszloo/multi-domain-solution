<?php

namespace App\Application\Contract;

use App\Domain\Entity\Brand;

interface BrandServiceInterface
{
    /**
     * @return array{data: Brand[], example: string}
     */
    public function getDummyExample(): array;
}
