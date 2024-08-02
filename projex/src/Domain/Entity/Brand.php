<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity, Table(name: 'brand')]
#[Index(name: 'i_sef', columns: ['sef'])]
final class Brand
{
    use DateTimeTrait;

    #[Id, Column(name: 'id', type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[Column(name: 'name', type: 'string', unique: true, nullable: false)]
    private string $name;

    #[Column(name: 'sef', type: 'string', unique: true, nullable: false)]
    private string $sef;

    #[Column(name: 'live', type: 'boolean', nullable: false)]
    private bool $live;

    #[OneToMany(targetEntity: Category::class, mappedBy: 'brand', cascade: ['persist'])]
    private Collection $categories;

    public function __construct()
    {
        $this->init();
        $this->categories = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSef(): string
    {
        return $this->sef;
    }

    public function setSef(string $sef): self
    {
        $this->sef = $sef;

        return $this;
    }

    public function getLive(): bool
    {
        return $this->live;
    }

    public function setLive(bool $live): self
    {
        $this->live = $live;

        return $this;
    }

    public function getCategories(): Collection
    {
        return $this->categories;
    }
}
