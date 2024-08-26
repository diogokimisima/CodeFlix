<?php

namespace Tests\Unit\UseCase\Video;

use Core\UseCase\Interfaces\FileStorageInterface;
use Core\Domain\Repository\VideoRepositoryInterface;
use Core\UseCase\Interfaces\TransactionInterface;
use Core\UseCase\Video\CreateVideoUseCase as UseCase;
use Mockery;
use PHPUnit\Framework\TestCase;
use stdClass;

class CreateVideoUseCaseUnitTest extends TestCase
{
    public function test_constructor()
    {
       $useCase = new UseCase(
            repository: $this->createMockRepository(),
            transaction: $this->createMockTransaction(),
            storage: $this->createMockFileStorage()
       );


    }

    private function createMockRepository()
    {
        return Mockery::mock(stdClass::class, VideoRepositoryInterface::class);
    }

    private function createMockTransaction()
    {
        return Mockery::mock(stdClass::class, TransactionInterface::class);
    }

    private function createMockFileStorage()
    {
        return Mockery::mock(stdClass::class, FileStorageInterface::class);
    }
}
