<?php

declare (strict_types = 1);

namespace Mihaeu\Hotshowers;

use Mihaeu\Hotshowers\Helpers\UserTestHelper;

/**
 * @covers Mihaeu\Hotshowers\UserRepository
 *
 * @uses Mihaeu\Hotshowers\User
 * @uses Mihaeu\Hotshowers\Name
 * @uses Mihaeu\Hotshowers\FirstName
 * @uses Mihaeu\Hotshowers\LastName
 * @uses Mihaeu\Hotshowers\UserCollection
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
class UserRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var UserRepository */
    private $userRepository;

    /** @var UserMapper|\PHPUnit_Framework_MockObject_MockObject */
    private $userMapper;

    public function setUp()
    {
        $this->userMapper = $this->getMockBuilder(UserMapper::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->userRepository = new UserRepository($this->userMapper);
    }

    public function testFindsByUsername()
    {
        $this->userMapper->method('findByUsername')->willReturn(UserTestHelper::userCollection());
        $this->userMapper->method('findByEmail')->willReturn(new UserCollection());
        $this->userMapper->method('findByName')->willReturn(new UserCollection());
        $this->userMapper->method('findByCity')->willReturn(new UserCollection());
        $this->assertEquals(UserTestHelper::userCollection(), $this->userRepository->findByNameEmailCityUsername('Test'));
    }

    public function testFindsByName()
    {
        $this->userMapper->method('findByUsername')->willReturn(new UserCollection());
        $this->userMapper->method('findByEmail')->willReturn(UserTestHelper::userCollection());
        $this->userMapper->method('findByName')->willReturn(new UserCollection());
        $this->userMapper->method('findByCity')->willReturn(new UserCollection());
        $this->assertEquals(UserTestHelper::userCollection(), $this->userRepository->findByNameEmailCityUsername('Test'));
    }

    public function testFindsByEmail()
    {
        $this->userMapper->method('findByUsername')->willReturn(new UserCollection());
        $this->userMapper->method('findByEmail')->willReturn(new UserCollection());
        $this->userMapper->method('findByName')->willReturn(UserTestHelper::userCollection());
        $this->userMapper->method('findByCity')->willReturn(new UserCollection());
        $this->assertEquals(UserTestHelper::userCollection(), $this->userRepository->findByNameEmailCityUsername('Test'));
    }

    public function testFindsByCity()
    {
        $this->userMapper->method('findByUsername')->willReturn(new UserCollection());
        $this->userMapper->method('findByEmail')->willReturn(new UserCollection());
        $this->userMapper->method('findByName')->willReturn(new UserCollection());
        $this->userMapper->method('findByCity')->willReturn(UserTestHelper::userCollection());
        $this->assertEquals(UserTestHelper::userCollection(), $this->userRepository->findByNameEmailCityUsername('Test'));
    }

    public function testFindsNothing()
    {
        $this->userMapper->method('findByUsername')->willReturn(new UserCollection());
        $this->userMapper->method('findByEmail')->willReturn(new UserCollection());
        $this->userMapper->method('findByName')->willReturn(new UserCollection());
        $this->userMapper->method('findByCity')->willReturn(new UserCollection());
        $this->assertEquals(new UserCollection(), $this->userRepository->findByNameEmailCityUsername('Test'));
    }
}
