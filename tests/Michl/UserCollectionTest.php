<?php

declare (strict_types = 1);

namespace Mihaeu\Hotshowers;

use Mihaeu\Hotshowers\Helpers\UserTestHelper;

/**
 * @covers Mihaeu\Hotshowers\UserCollection
 * @covers Mihaeu\Hotshowers\Util\AbstractCollection
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
class UserCollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testCount()
    {
        $this->assertCount(2, (new UserCollection())
            ->add(UserTestHelper::user('user1'))
            ->add(UserTestHelper::user('user2'))
        );
    }

    public function testMapToArray()
    {
        $this->assertEquals(['user1', 'user2'], (new UserCollection())
            ->add(UserTestHelper::user('user1'))
            ->add(UserTestHelper::user('user2'))
            ->mapToArray(function (User $user) {
                return $user->username();
            })
        );
    }

    public function testReduce()
    {
        $this->assertEquals('user1user2', (new UserCollection())
            ->add(UserTestHelper::user('user1'))
            ->add(UserTestHelper::user('user2'))
            ->reduce('', function (string $initial, User $user) {
                return $initial.$user->username();
            })
        );
    }

    public function testToArray()
    {
        $users = (new UserCollection())
            ->add(UserTestHelper::user('user1'))
            ->add(UserTestHelper::user('user2'));
        $this->assertEquals(UserTestHelper::user('user1'), $users->toArray()[0]);
        $this->assertEquals(UserTestHelper::user('user2'), $users->toArray()[1]);
    }

    public function testAddAll()
    {
        $users1 = (new UserCollection())
            ->add(UserTestHelper::user('user1'))
            ->add(UserTestHelper::user('user3'));

        $users2 = (new UserCollection())
            ->add(UserTestHelper::user('user2'))
            ->add(UserTestHelper::user('user4'));

        $allUsers = $users1->addAll($users2);
        $this->assertEquals(UserTestHelper::user('user1'), $allUsers->toArray()[0]);
        $this->assertEquals(UserTestHelper::user('user3'), $allUsers->toArray()[1]);
        $this->assertEquals(UserTestHelper::user('user2'), $allUsers->toArray()[2]);
        $this->assertEquals(UserTestHelper::user('user4'), $allUsers->toArray()[3]);
    }

    public function testFilter()
    {
        (new UserCollection())
            ->add(UserTestHelper::user('user1'))
            ->add(UserTestHelper::user('user3'))
            ->filter(function (User $user) {
                return (string) $user->username() === 'user1';
            })->each(function (User $user) {
                $this->assertEquals('user1', $user->username());
            });
    }
}
