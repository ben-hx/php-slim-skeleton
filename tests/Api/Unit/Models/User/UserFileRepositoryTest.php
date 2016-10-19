<?php

declare (strict_types = 1);

namespace BenHx\Api\Test\Unit\Models\User;

use BenHx\Api\Models\User\UserFileRepository;
use BenHx\Api\Models\User\User;
use BenHx\Api\Exceptions\FileNotWritableException;
use \BenHx\Api\Exceptions\ValidationException;
use BenHx\Api\Test\Helpers\UtilTestHelper;

class UserFileRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var UserFileMapper */
    private $mapper;

    /** @var \SplFileInfo */
    private $file;

    public function setUp()
    {
        $this->file = new \SplFileInfo(tempnam(sys_get_temp_dir(), microtime()));
        $this->repository = new UserFileRepository($this->file);
    }

    public function tearDown()
    {
        UtilTestHelper::unlinkFile($this->file->getPathname());
    }

    private function saveExapmleUser(
        string $username,
        string $password = '1234',
        string $firstName = 'testfirstname',
        string $lastName = 'testlastname',
        string $email = 'test@test.com'
    ) : User {
        return $this->repository->create($username, $password, $firstName, $lastName, $email);
    }

    public function testThatFileHasToBeWritableIsThrownWhenNotReadable()
    {
        $this->expectException(FileNotWritableException::class);
        chmod($this->file->getPathname(), 0444);
        new UserFileRepository($this->file);
    }

    public function testThatCreateReturnsAValidUser()
    {
        $username = "user";
        $password = '1234';
        $firstName = 'testfirstname';
        $lastName = 'testlastname';
        $email = 'test@test.com';
        $user = $this->saveExapmleUser($username, $password, $firstName, $lastName, $email);
        $this->assertEquals($user->getUsername(), $username);
        $this->assertEquals($user->getFirstName(), $firstName);
        $this->assertEquals($user->getLastName(), $lastName);
        $this->assertEquals($user->getEmail(), $email);
        $this->assertTrue($user->verifyPassword($password));
    }

    public function testThatCreatingDulicatedUsernamesThrowsValidationException()
    {
        $this->expectException(ValidationException::class);
        $this->saveExapmleUser('user1');
        $this->saveExapmleUser('user1');
    }

    public function testThatGetAllReturnsSavedValues()
    {
        $user1 = $this->saveExapmleUser('user1');
        $user2 = $this->saveExapmleUser('user2');
        $user3 = $this->saveExapmleUser('user3');
        $userArray = $this->repository->getAll()->toArray();
        $this->assertEquals((int) in_array($user1, $userArray), 1);
        $this->assertEquals((int) in_array($user2, $userArray), 1);
        $this->assertEquals((int) in_array($user3, $userArray), 1);
    }

    public function testThatAnEmptyRepositoryResultsInFindingNothing()
    {
        $this->assertEmpty($this->repository->getAll()->toArray());
    }

    public function testThatFindByUsernameFindsUserContainingTheRepositry()
    {
        $user1 = $this->saveExapmleUser('user1');
        $user2 = $this->saveExapmleUser('user2');
        $user3 = $this->saveExapmleUser('user3');
        $foundedUser1 = $this->repository->findByUsername('user1');
        $this->assertEquals($foundedUser1, $user1);
        $foundedUser2 = $this->repository->findByUsername('user2');
        $this->assertEquals($foundedUser2, $user2);
        $foundedUser3 = $this->repository->findByUsername('user2');
        $this->assertEquals($foundedUser3, $user2);
    }

    public function testThatFindByUsernameDoesNotFindUserNotContainingTheRepositry()
    {
        $user1 = $this->saveExapmleUser('user1');
        $user2 = $this->saveExapmleUser('user2');
        $user3 = $this->saveExapmleUser('user3');
        $foundedUser4 = $this->repository->findByUsername('user4');
        $this->assertNull($foundedUser4);
    }
}