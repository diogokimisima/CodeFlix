<?php

namespace Core\Domain\Repository;

use Core\Domain\Entity\Category;

interface CategoryRepositoryInterface extends EntityRepositoryInterface
{
    public function getIdsListIds(array $categoriesId = []): array;
}