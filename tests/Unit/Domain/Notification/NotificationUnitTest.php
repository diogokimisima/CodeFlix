<?php

namespace Tests\Unit\Domain\Notification;

use Core\Domain\Notification\Notification;
use PHPUnit\Framework\TestCase;

class NotificationUnitTest extends TestCase
{
    public function testGetErrors()
    {
        $notification = new Notification();
        $errors = $notification->getErrors();


        $this->assertIsArray($errors);
    }

    public function testAddErrors()
    {
        $notification = new Notification();
        $notification->addError([
            'context' => 'video',
            'message' => 'video title is required',
        ]);

        $errors = $notification->getErrors();

        $this->assertCount(1, $errors);
    }

    public function testHasError()
    {
        $notification = new Notification();
        $hasErrors = $notification->hasErrors();
        $this->assertFalse($hasErrors);

        $notification->addError([
            'context' => 'video',
            'message' => 'video title is required',
        ]);

        $this->assertTrue($notification->hasErrors());
    }

    public function testMessage()
    {
        $notification = new Notification();

        $notification->addError([
            'context' => 'video',
            'message' => 'video title is required',
        ]);
        $notification->addError([
            'context' => 'video',
            'message' => 'description title is required',
        ]);

        $message = $notification->messages();
        dump($message);

        $this->assertIsString($message);
        $this->assertEquals(
            expected: 'video: video title is required,video: description title is required,',
            actual: $message
        );
    }
}
