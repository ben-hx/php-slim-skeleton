<?php

declare (strict_types = 1);

namespace Mihaeu\Hotshowers\Message;

use Mihaeu\Hotshowers\Helpers\UserTestHelper;

/**
 * @covers Mihaeu\Hotshowers\Message\Message
 *
 * @uses Mihaeu\Hotshowers\Message\Subject
 * @uses Mihaeu\Hotshowers\Message\Body
 * @uses Mihaeu\Hotshowers\User
 * @uses Mihaeu\Hotshowers\Name
 * @uses Mihaeu\Hotshowers\FirstName
 * @uses Mihaeu\Hotshowers\LastName
 * @uses Mihaeu\Hotshowers\Username
 * @uses Mihaeu\Hotshowers\Email
 * @uses Mihaeu\Hotshowers\Address
 * @uses Mihaeu\Hotshowers\Password
 * @uses Mihaeu\Hotshowers\Location
 * @uses Mihaeu\Hotshowers\PhoneNumber
 * @uses Mihaeu\Hotshowers\City
 * @uses Mihaeu\Hotshowers\Country
 * @uses Mihaeu\Hotshowers\HouseNumber
 * @uses Mihaeu\Hotshowers\Street
 * @uses Mihaeu\Hotshowers\ZipCode
 */
class MessageTest extends \PHPUnit_Framework_TestCase
{
    /** @var Message */
    private $message;

    public function setUp()
    {
        $this->message = new Message(
            new Subject('subject'),
            new Body('body'),
            UserTestHelper::user('user1'),
            UserTestHelper::user('user2')
        );
    }

    public function testHasSubject()
    {
        $this->assertEquals(new Subject('subject'), $this->message->subject());
    }

    public function testHasBody()
    {
        $this->assertEquals(new Body('body'), $this->message->body());
    }

    public function testHasFrom()
    {
        $this->assertEquals(UserTestHelper::user('user1'), $this->message->from());
    }

    public function testHasTo()
    {
        $this->assertEquals(UserTestHelper::user('user2'), $this->message->to());
    }
}
