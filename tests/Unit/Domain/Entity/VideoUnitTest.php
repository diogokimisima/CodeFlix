<?php

namespace Tests\Unit\Domain\Entity;

use Core\Domain\Entity\Video;
use Core\Domain\Enum\MediaStatus;
use Core\Domain\Enum\Rating;
use Core\Domain\Notification\NotificationException;
use Core\Domain\ValueObject\{
    Image,
    Media
};
use Core\Domain\ValueObject\Uuid as ValueObjectUuid;
use DateTime;
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
            published: true,
            createdAt: new DateTime(date('Y-m-d H:i:s'))
        );

        $this->assertEquals($uuid, $entity->id());
        $this->assertEquals('title', $entity->title);
        $this->assertEquals('description', $entity->description);
        $this->assertEquals('2029', $entity->yearLaunched);
        $this->assertEquals(12, $entity->duration);
        $this->assertEquals(true, $entity->opened);
        $this->assertEquals(Rating::RATE12, $entity->rating);
        $this->assertEquals(true, $entity->published);
        $this->assertEquals(date('Y-m-d H:i:s'), $entity->createdAt->format('Y-m-d H:i:s'));
    }

    public function testIdAndCreated()
    {
        $entity = new Video(
            title: 'title',
            description: 'description',
            yearLaunched: 2029,
            duration: 12,
            opened: true,
            rating: Rating::RATE12,
        );

        $this->assertNotEmpty($entity->id());
        $this->assertNotEmpty($entity->createdAt());
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
    public function testAddGenre()
    {
        $genreId = (string) Uuid::uuid4();

        $entity = new Video(
            title: 'title',
            description: 'description',
            yearLaunched: 2029,
            duration: 12,
            opened: true,
            rating: Rating::RATE12,
            published: true,
        );

        $this->assertCount(0, $entity->genresId);

        $entity->addGenreId(
            genreId: $genreId
        );
        $entity->addGenreId(
            genreId: $genreId
        );

        $this->assertCount(2, $entity->genresId);
    }

    public function testRemoveGenre()
    {
        $genreId = (string) Uuid::uuid4();

        $entity = new Video(
            title: 'title',
            description: 'description',
            yearLaunched: 2029,
            duration: 12,
            opened: true,
            rating: Rating::RATE12,
            published: true,

        );

        $entity->addGenreId(
            genreId: $genreId
        );

        $this->assertCount(1, $entity->genresId);

        $entity->removeGenreId(
            genreId: $genreId
        );

        $this->assertCount(0, $entity->genresId);
    }

    public function testAddCastMember()
    {
        $castMemberId = (string) Uuid::uuid4();

        $entity = new Video(
            title: 'title',
            description: 'description',
            yearLaunched: 2029,
            duration: 12,
            opened: true,
            rating: Rating::RATE12,
            published: true,
        );

        $this->assertCount(0, $entity->castMembersId);

        $entity->addCastMemberId(
            castMemberId: $castMemberId
        );
        $entity->addCastMemberId(
            castMemberId: $castMemberId
        );

        $this->assertCount(2, $entity->castMembersId);
    }

    public function testRemoveCastMember()
    {
        $castMemberId = (string) Uuid::uuid4();

        $entity = new Video(
            title: 'title',
            description: 'description',
            yearLaunched: 2029,
            duration: 12,
            opened: true,
            rating: Rating::RATE12,
            published: true,
        );

        $entity->addCastMemberId(
            castMemberId: $castMemberId
        );

        $this->assertCount(1, $entity->castMembersId);

        $entity->removeCastMemberId(
            castMemberId: $castMemberId
        );

        $this->assertCount(0, $entity->castMembersId);
    }

    public function testValueObjectImage()
    {
        $entity = new Video(
            title: 'title',
            description: 'description',
            yearLaunched: 2029,
            duration: 12,
            opened: true,
            rating: Rating::RATE12,
            thumbFile: new Image(
                path: 'teste-path/image.png'
            ),
        );

        $this->assertNotNull($entity->thumbFile());
        $this->assertInstanceOf(Image::class, $entity->thumbFile());
        $this->assertEquals('teste-path/image.png', $entity->thumbFile()->getPath());
    }

    public function testValueObjectImageThumbHalf()
    {
        $entity = new Video(
            title: 'title',
            description: 'description',
            yearLaunched: 2029,
            duration: 12,
            opened: true,
            rating: Rating::RATE12,
            thumbHalf: new Image(
                path: 'teste-path/image.png'
            ),
        );

        $this->assertNotNull($entity->thumbHalf());
        $this->assertInstanceOf(Image::class, $entity->thumbHalf());
        $this->assertEquals('teste-path/image.png', $entity->thumbHalf()->getPath());
    }

    public function testValueObjectImageToBannerFile()
    {
        $entity = new Video(
            title: 'title',
            description: 'description',
            yearLaunched: 2029,
            duration: 12,
            opened: true,
            rating: Rating::RATE12,
            bannerFile: new Image('teste-path/image.png'),
        );

        $this->assertNotNull($entity->bannerFile());
        $this->assertInstanceOf(Image::class, $entity->bannerFile());
        $this->assertEquals('teste-path/image.png', $entity->bannerFile()->getPath());
    }

    public function testValueObjectMedia()
    {
        $trailerFile = new Media(
            filePath: 'path/video.mp4',
            mediaStatus: MediaStatus::PENDING,
            encodedPath: 'path/encoded.extension',
        );

        $entity = new Video(
            title: 'title',
            description: 'description',
            yearLaunched: 2029,
            duration: 12,
            opened: true,
            rating: Rating::RATE12,
            trailerFile: $trailerFile,
        );

        $this->assertNotNull($entity->trailerFile());
        $this->assertInstanceOf(Media::class, $entity->trailerFile());
        $this->assertEquals('path/video.mp4', $entity->trailerFile()->filePath);
    }


    public function testValueObjectMediaVideo()
    {
        $videoFile = new Media(
            filePath: 'path/video.mp4',
            mediaStatus: MediaStatus::PENDING,
        );

        $entity = new Video(
            title: 'title',
            description: 'description',
            yearLaunched: 2029,
            duration: 12,
            opened: true,
            rating: Rating::RATE12,
            videoFile: $videoFile,
        );

        $this->assertNotNull($entity->videoFile());
        $this->assertInstanceOf(Media::class, $entity->videoFile());
        $this->assertEquals('path/video.mp4', $entity->videoFile()->filePath);
    }

    public function testException()
    {
        $this->expectException(NotificationException::class);
        
        new Video(
            title: 'ts',
            description: 'de',
            yearLaunched: 2029,
            duration: 12,
            opened: true,
            rating: Rating::RATE12,
        );
    }
}
