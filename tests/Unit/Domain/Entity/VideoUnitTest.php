<?php

namespace Tests\Unit\Domain\Entity;

use Core\Domain\Entity\Traits\MethodsMagicsTrait;
use Core\Domain\Entity\Video;
use Core\Domain\Enum\Rating;
use Core\Domain\ValueObject\Uuid as ValueObjectUuid;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class VideoUnitTest extends TestCase
{

    public function testAttributes()
    {
        $uuid = (string) Uuid::uuid4();

        $entity = new Video(
            id: new ValueObjectUuid($uuid),
            title: 'title',
            description: 'description',
            yearLaunched: 2029,
            duration: 12,
            opened: true,
            rating: Rating::RATE12,
            publish: true,
        );

        $this->assertEquals($uuid, $entity->id());    	
        $this->assertEquals('title', $entity->title);    	
        $this->assertEquals('description', $entity->description);    	
        $this->assertEquals('2029', $entity->yearLaunched);    	
        $this->assertEquals(12, $entity->duration);    	
        $this->assertEquals(true, $entity->opened);    	
        $this->assertEquals(Rating::RATE12, $entity->rating);    	
        $this->assertEquals(true, $entity->publish);    	
    }

    public function testId()
    {
        $entity = new Video(
            title: 'title',
            description: 'description',
            yearLaunched: 2029,
            duration: 12,
            opened: true,
            rating: Rating::RATE12,
            published: true,
        );

        $this->assertNotEmpty($entity->id());    	
    }

    public function testAddCategory()
    {
        $categoryId = (string) Uuid::uuid4();

        $entity = new Video(
            title: 'title',
            description: 'description',
            yearLaunched: 2029,
            duration: 12,
            opened: true,
            rating: Rating::RATE12,
            published: true,
        );

        $this->assertCount(0, $entity->categoriesId);

        $entity->addCategoryId(
            categoryId: $categoryId
        );
        $entity->addCategoryId(
            categoryId: $categoryId
        );
        
        $this->assertCount(2, $entity->categoriesId);
    }

    public function testRemoveCategory()
    {
        $categoryId = (string) Uuid::uuid4();

        $entity = new Video(
            title: 'title',
            description: 'description',
            yearLaunched: 2029,
            duration: 12,
            opened: true,
            rating: Rating::RATE12,
            published: true,
        );

        $entity->addCategoryId(
            categoryId: $categoryId
        );
        
        $this->assertCount(1, $entity->categoriesId);

        $entity->removeCategoryId(
            categoryId: $categoryId
        );

        $this->assertCount(0, $entity->categoriesId);
    }

}