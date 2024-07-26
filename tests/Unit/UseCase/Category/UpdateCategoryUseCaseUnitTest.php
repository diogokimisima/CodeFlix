<?php

namespace Tests\Unit\UseCase\Category;

use Core\Domain\Entity\Category as EntityCategory;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class UpdateCategoryUseCaseUnitTest extends TestCase
{
    public function testRenameCategory()
    {
        $uuid = (string) Uuid::uuid4()->toString();
        $categoryName = 'Name';
        $categoryDesc = 'Desc';

        $this->mockEntity = Mockery::mock(EntityCategory::class, [
            $uuid,
            $categoryName,
            $categoryDesc
        ]);

        $this->mockRepo->shouldReceive('update');

        $this->mockRepo = Mockery::mock(stdClass::class, CategoryRepositoryInterface);
        $this->mockRepo->shouldReceive('findById')->andReturn($this->mockEntity);
        $this->mockRepo->shouldReceive('update')->andReturn($this->mockEntity);

        $this->mockInputDto = Mockery::mock(
            UpdateCategoryInputDto::class,
            $uuid,
            'new name',
        );

        $useCase = new  UpdateCategoryUseCase($this->mockRepo);
        $responseUseCase = $useCase->execute($this->mockInputDto);

        $this->assertInstanceOf(CategoryUpdateOutputDto::class);
    }
}
