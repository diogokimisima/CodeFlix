<?php

namespace Tests\Feature\App\Repositories;

use App\Models\Genre as Model;
use App\Repositories\Eloquent\GenreEloquentRepository;
use Core\Domain\Entity\Genre as EntityGenre;
use Tests\TestCase;

class GenreEloquentRepositoryTest extends TestCase
{
    protected $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = new GenreEloquentRepository(new Model());
    }

    public function testInsert()
    {
        $entity = new EntityGenre(name: 'New Genre');

        $response = $this->repository->insert($entity);

        dump($response);
    }
}
