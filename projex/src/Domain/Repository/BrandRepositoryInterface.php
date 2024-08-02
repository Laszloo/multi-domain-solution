<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Brand;

interface BrandRepositoryInterface
{
    /**
     * @return Brand[]
     */
    public function findAllActive(): array;

    public function findOneBySef(int $sef): ?Brand;
}
