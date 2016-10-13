<?php

namespace Mihaeu\Hotshowers;

use Mihaeu\Hotshowers\Helpers\UserTestHelper;

/**
 * @covers Mihaeu\Hotshowers\User
 *
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
class UserTest extends \PHPUnit_Framework_TestCase
{
    /** @var User */
    private $user;

    /** @var Address */
    private $address;

    public function setUp()
    {
        $this->address = new Address(
            new City('Testcity'),
            new Country('DE'),
            new ZipCode(12345),
            new Street('Test'),
            new HouseNumber('123abc')
        );

        $this->user = UserTestHelper::user();
    }

    public function testHasName()
    {
        $expectedName = new Name(new FirstName('First'), new LastName('Last'));
        $this->assertEquals($expectedName, $this->user->name());
    }

    public function testHasUsername()
    {
        $this->assertEquals(new Username('Test'), $this->user->username());
    }

    public function testHasEmail()
    {
        $this->assertEquals(new Email('test@test.com'), $this->user->email());
    }

    public function testHasAddress()
    {
        $this->assertEquals($this->address, $this->user->address());
    }

    public function testHasPassword()
    {
        $this->assertEquals(new Password('1234'), $this->user->password());
    }

    public function testHasLocation()
    {
        $this->assertEquals(new Location(1.23456789, 9.87654321), $this->user->location());
    }

    public function testHasPhoneNumber()
    {
        $this->assertEquals(new PhoneNumber('+123456789'), $this->user->phoneNumber());
    }
}
