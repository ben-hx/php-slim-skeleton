<?php

declare (strict_types = 1);

namespace BenHx\Api\Test\Helpers;

use BenHx\Api\Models\User\User;

class UserTestHelper
{
    public static function user(
        string $id,
        string $username = 'testname',
        string $password = '1234',
        string $firstName = 'testfirstname',
        string $lastName = 'testlastname',
        string $email = 'test@test.com',
        string $phone = '1234'
    ) : User
    {
        return new User($id, $username, $password, $firstName, $lastName, $email, $phone);
    }

    public static function userCollection() : UserCollection
    {
        $users = new UserCollection();
        $users->add(self::user());
        return $users;
    }

    public static function userEquals(User $user1, User $user2): bool
    {
        return $user1->getId() === $user2->getId() &&
        $user1->getUsername() === $user2->getUsername() &&
        $user1->getEmail() === $user2->getEmail() &&
        $user1->getLastName() === $user2->getLastName() &&
        $user1->getFirstName() === $user2->getFirstName();
    }
}
