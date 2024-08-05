<?php

namespace Core\Domain\Entity;

use Core\Domain\ValueObject\Uuid;
use DateTime;

class Genre
{
    public function __construct(
        protected Uuid|null $id = null,
        protected string $name,
        protected DateTime|null $createdAt = null,
        protected $isActive = true
    ) 
    {
        $this->id = $this->id ?? Uuid::random();
        $this->createdAt = $this->createdAt ?? new DateTime();
    }
}
