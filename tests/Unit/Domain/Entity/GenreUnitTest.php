<?php

namespace Tests\Unit\Domain\Entity;

use Core\Domain\Entity\Genre;
use Core\Domain\ValueObject\Uuid;
use DateTime;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid as RamseyUuid;

class GenreUnitTest extends TestCase
{
    public function testAttributes()
    {
        $uuid = (string) RamseyUuid::uuid4();
        $date = date('Y-m-d H:i:s');

        $genre = new Genre(
            id: new Uuid($uuid),
            name: 'New Genre',
            isActive: false,
            createdAt: new DateTime(date('Y-m-d H:i:s')),
        );

        $this->assertEquals($uuid, $genre->id());
        $this->assertEquals('New Genre', $genre->name);
        $this->assertEquals(false, $genre->isActive);
        $this->assertEquals($date, $genre->createdAt());
    }

    public function testAttributesCreate()
    {
        $genre = new Genre(
            name: 'New Genre',
        );

        $this->assertNotEmpty($genre->id());
        $this->assertEquals('New Genre', $genre->name);
        $this->assertEquals(true, $genre->isActive);
        $this->assertNotEmpty($genre->createdAt());
    }

    public function testDeactivate()
    {
        $genre = new Genre(
            name: "test"
        );

        $this->assertTrue($genre->isActive);  
        
        $genre->deactivate();

        $this->assertFalse($genre->isActive);  
    }

    public function testActivate()
    {
        $genre = new Genre(
            name: "test",
            isActive: false,
        );

        $this->assertFalse($genre->isActive);  

        $genre->activate();

        $this->assertTrue($genre->isActive);
    }
}
