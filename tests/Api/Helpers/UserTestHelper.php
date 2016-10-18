<?php

declare (strict_types = 1);

namespace BenHx\Api\Test\Helpers;

use BenHx\Api\Models\User\User;

class UserTestHelper
{
    public static function user(
        string $username = 'testname',
        string $password = '1234',
        string $firstName = 'testfirstname',
        string $lastName = 'testlastname',
        string $email = 'test@test.com',
        string $phone = '1234'
    ) : User {
        $id = random_bytes(7);
        return new User($id, $username, $password, $firstName, $lastName, $email, $phone);
    }

    public static function userCollection() : UserCollection
    {
        $users = new UserCollection();
        $users->add(self::user());
        return $users;
    }
}
