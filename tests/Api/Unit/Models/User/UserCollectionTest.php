<?php

declare (strict_types = 1);

namespace BenHx\Api\Test\Unit\Models\User;

use BenHx\Api\Models\User\User;
use BenHx\Api\Models\User\UserCollection;
use BenHx\Api\Test\Helpers\UserTestHelper;

class UserCollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testThatCountReturnsTheCorrectNumberOfUsers()
    {
        $this->assertCount(2, (new UserCollection())
            ->add(UserTestHelper::user('user1'))
            ->add(UserTestHelper::user('user2'))
        );
    }

    public function testThatMapToArrayReturnsTheAArray()
    {
        $this->assertEquals(['user1', 'user2'], (new UserCollection())
            ->add(UserTestHelper::user('user1'))
            ->add(UserTestHelper::user('user2'))
            ->mapToArray(function (User $user) {
                return $user->getId();
            })
        );
    }

    public function testThatReduceReturnsACorrectElement()
    {
        $this->assertEquals('user1user2', (new UserCollection())
            ->add(UserTestHelper::user('user1'))
            ->add(UserTestHelper::user('user2'))
            ->reduce('', function (string $initial, User $user) {
                return $initial.$user->getId();
            })
        );
    }

    public function testThatToArrayReturnsACorrectArray()
    {
        $users = (new UserCollection())
            ->add(UserTestHelper::user('user1'))
            ->add(UserTestHelper::user('user2'));
        $this->assertTrue(UserTestHelper::userEquals(UserTestHelper::user('user1'), $users->toArray()[0]));
        $this->assertTrue(UserTestHelper::userEquals(UserTestHelper::user('user2'), $users->toArray()[1]));
    }

    public function testThatAddAllAddsTheCorrectElements()
    {
        $users1 = (new UserCollection())
            ->add(UserTestHelper::user('user1'))
            ->add(UserTestHelper::user('user3'));

        $users2 = (new UserCollection())
            ->add(UserTestHelper::user('user2'))
            ->add(UserTestHelper::user('user4'));

        $allUsers = $users1->addAll($users2);

        $this->assertTrue(UserTestHelper::userEquals(UserTestHelper::user('user1'), $allUsers->toArray()[0]));
        $this->assertTrue(UserTestHelper::userEquals(UserTestHelper::user('user3'), $allUsers->toArray()[1]));
        $this->assertTrue(UserTestHelper::userEquals(UserTestHelper::user('user2'), $allUsers->toArray()[2]));
        $this->assertTrue(UserTestHelper::userEquals(UserTestHelper::user('user4'), $allUsers->toArray()[3]));
    }

    public function testThatFilterReturnsTheCorrectElements()
    {
        (new UserCollection())
            ->add(UserTestHelper::user('user1'))
            ->add(UserTestHelper::user('user3'))
            ->filter(function (User $user) {
                return (string) $user->getId() === 'user1';
            })->each(function (User $user) {
                $this->assertEquals('user1', $user->getId());
            });
    }
}