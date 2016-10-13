<?php

declare (strict_types = 1);

namespace Mihaeu\Hotshowers;

use Mihaeu\Hotshowers\Exceptions\FileNotReadableException;
use Mihaeu\Hotshowers\Exceptions\FileNotWritableException;
use Mihaeu\Hotshowers\Helpers\UserTestHelper;

/**
 * @covers Mihaeu\Hotshowers\UserFileMapper
 *
 * @uses Mihaeu\Hotshowers\User
 * @uses Mihaeu\Hotshowers\UserCollection
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
 * @uses Mihaeu\Hotshowers\Util\AbstractCollection
 */
class UserFileMapperTest extends \PHPUnit_Framework_TestCase
{
    /** @var UserFileMapper */
    private $mapper;

    /** @var \SplFileInfo */
    private $file;

    public function setUp()
    {
        $this->file = new \SplFileInfo(tempnam(sys_get_temp_dir(), microtime()));
        $this->mapper = new UserFileMapper($this->file);
    }

    public function tearDown()
    {
        //unlink($this->file->getPathname());
    }

    public function testReadAndWrite()
    {
        $user = UserTestHelper::user();
        $this->mapper->save($user);
        $userArray = $this->mapper->findAll()->toArray();
        $this->assertEquals($user, $userArray[0]);
    }

    public function testFindNothing()
    {
        $this->assertEmpty($this->mapper->findAll()->toArray());
    }

    public function testFindsByUsername()
    {
        $userNewYork = UserTestHelper::user('userNewYork');
        $this->mapper->save($userNewYork);
        $userBerlin = UserTestHelper::user('userBerlin');
        $this->mapper->save($userBerlin);
        $userYork = UserTestHelper::user('userYork');
        $this->mapper->save($userYork);
        $userArray = $this->mapper->findByUsername('York')->toArray();
        $this->assertEquals($userArray[0], $userNewYork);
        $this->assertEquals($userArray[1], $userYork);
    }

    public function testFindsByEmail()
    {
        $user1 = UserTestHelper::user('user1', 'same@gmail.com', 'Berlin');
        $this->mapper->save($user1);
        $user2 = UserTestHelper::user('user2', 'same@yahoo.com', 'New York');
        $this->mapper->save($user2);
        $user3 = UserTestHelper::user('user3', 'same@live.com', 'Berlin');
        $this->mapper->save($user3);
        $userArray = $this->mapper->findByEmail('@yahoo')->toArray();
        $this->assertEquals($userArray[0], $user2);
    }

    public function testFindsByCity()
    {
        $user1 = UserTestHelper::user('user1', 'same@email.com', 'Berlin');
        $this->mapper->save($user1);
        $user2 = UserTestHelper::user('user2', 'same@email.com', 'New York');
        $this->mapper->save($user2);
        $user3 = UserTestHelper::user('user3', 'same@email.com', 'Berlin');
        $this->mapper->save($user3);
        $userArray = $this->mapper->findByCity('Berlin')->toArray();
        $this->assertEquals($userArray[0], $user1);
        $this->assertEquals($userArray[1], $user3);
    }

    public function testFindsByName()
    {
        $user1 = UserTestHelper::user('user1', 'same@email.com', 'Berlin', 'John', 'Smith');
        $this->mapper->save($user1);
        $user2 = UserTestHelper::user('user2', 'same@email.com', 'Berlin', 'Marcus', 'John');
        $this->mapper->save($user2);
        $user3 = UserTestHelper::user('user3', 'same@email.com', 'Berlin', 'Steve', 'McKinley');
        $this->mapper->save($user3);
        $userArray = $this->mapper->findByName('John')->toArray();
        $this->assertEquals($userArray[0], $user1);
        $this->assertEquals($userArray[1], $user2);
    }

    /**
     * @covers Mihaeu\Hotshowers\Exceptions\FileNotReadableException
     */
    /*
    public function testStorageFileHasToBeReadable()
    {

        $this->expectException(FileNotReadableException::class);
        chmod($this->file->getPathname(), 0222);
        new UserFileMapper($this->file);

    }


    /**
     * @covers Mihaeu\Hotshowers\Exceptions\FileNotWritableException
     *
    public function testStorageFileHasToBeWritable()
    {
        $this->expectException(FileNotWritableException::class);
        chmod($this->file->getPathname(), 0444);
        new UserFileMapper($this->file);
    }
    */
}
