<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity, Table(name: 'category')]
final class Category
{
    use DateTimeTrait;

    #[Id, Column(name: 'id', type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[Column(name: 'name', type: 'string', unique: true, nullable: false)]
    private string $name;

    #[ManyToOne(targetEntity: Brand::class, inversedBy: 'categories')]
    #[JoinColumn(name: 'brand_id', referencedColumnName: 'id', nullable: false)]
    private Brand $brand;

    public function __construct()
    {
        $this->init();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Category
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Category
    {
        $this->name = $name;

        return $this;
    }

    public function getBrand(): Brand
    {
        return $this->brand;
    }
}
