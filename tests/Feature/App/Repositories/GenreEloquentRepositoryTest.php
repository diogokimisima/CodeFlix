<?php

namespace Tests\Feature\App\Repositories;

use App\Models\Category;
use App\Models\Genre as Model;
use App\Models\Genre;
use App\Repositories\Eloquent\GenreEloquentRepository;
use Core\Domain\Entity\Genre as EntityGenre;
use Core\Domain\Exception\NotFoundException;
use Core\Domain\Repository\GenreRepositoryInterface;
use Tests\TestCase;

class GenreEloquentRepositoryTest extends TestCase
{
    protected $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = new GenreEloquentRepository(new Model());
    }

    public function testImplementsInterface()
    {
        $this->assertInstanceOf(GenreRepositoryInterface::class, $this->repository);
    }

    public function testInsert()
    {
        $entity = new EntityGenre(name: 'New Genre');

        $response = $this->repository->insert($entity);
        $this->assertEquals($entity->name, $response->name);
        $this->assertEquals($entity->id, $response->id);

        $this->assertDatabaseHas('genres', [
            'id' => $entity->id,
            'name' => $entity->name,
            'created_at' => $entity->createdAt,
        ]);
    }

    public function testInsertDeactivate()
    {
        $entity = new EntityGenre(name: 'New Genre');
        $entity->deactivate();

        $response = $this->repository->insert($entity);
        $this->assertFalse($response->isActive);

        $this->assertDatabaseHas('genres', [
            'id' => $entity->id,
            'is_active' => false,
        ]);
    }

    public function testInsertWithRelationships()
    {
        $categories = Category::factory()->count(4)->create();

        $genre = new EntityGenre(name: 'teste');
        foreach ($categories as $category) {
            $genre->addCategory($category->id);
        }

        $response = $this->repository->insert($genre);

        $this->assertDatabaseHas('genres', [
            'id' => $response->id,
        ]);

        $this->assertDatabaseCount('category_genre', 4);
    }

    public function testFind()
    {
        $this->expectException(NotFoundException::class);
        $genre = 'fake_value';

        $this->repository->findById($genre);
    }

    public function testFindById()
    {
        $genre = Model::factory()->create();

        $response = $this->repository->findById($genre->id);

        $this->assertEquals($genre->id, $response->id());
        $this->assertEquals($genre->name, $response->name);
    }
}
