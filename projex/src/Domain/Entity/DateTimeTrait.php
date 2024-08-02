<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping\Column;

trait DateTimeTrait
{
    #[Column(name: 'updated_at', type: 'datetimetz_immutable', nullable: false)]
    private DateTimeImmutable $updatedAt;

    #[Column(name: 'created_at', type: 'datetimetz_immutable', nullable: false)]
    private DateTimeImmutable $createdAt;

    public function init(): void
    {
        if (empty($this->createdAt)) {
            $this->createdAt = new DateTimeImmutable('now');
        }
        $this->updatedAt = new DateTimeImmutable('now');
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
