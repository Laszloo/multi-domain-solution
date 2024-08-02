<?php

declare(strict_types=1);

namespace App\Domain\Sites\TestShopOrg\Infrastructure\Repository;

use App\Domain\Entity\Brand;
use App\Domain\Repository\BrandRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class LocalBrandRepository implements BrandRepositoryInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function findAllActive(): array
    {
        return $this->entityManager->getRepository(Brand::class)->findBy(['live' => false]);
    }

    public function findOneBySef(int $sef): ?Brand
    {
        return $this->entityManager->getRepository(Brand::class)->findOneBy(['sef' => '']);
    }
}
