<?php

declare (strict_types = 1);

namespace Mihaeu\Hotshowers\Helpers;

use Mihaeu\Hotshowers\Address;
use Mihaeu\Hotshowers\City;
use Mihaeu\Hotshowers\Country;
use Mihaeu\Hotshowers\Email;
use Mihaeu\Hotshowers\FirstName;
use Mihaeu\Hotshowers\HouseNumber;
use Mihaeu\Hotshowers\LastName;
use Mihaeu\Hotshowers\Location;
use Mihaeu\Hotshowers\Name;
use Mihaeu\Hotshowers\Password;
use Mihaeu\Hotshowers\PhoneNumber;
use Mihaeu\Hotshowers\Street;
use Mihaeu\Hotshowers\User;
use Mihaeu\Hotshowers\UserCollection;
use Mihaeu\Hotshowers\Username;
use Mihaeu\Hotshowers\ZipCode;

class UserTestHelper
{
    public static function user(
        string $username = 'Test',
        string $email = 'test@test.com',
        $city = 'Testcity',
        $firstName = 'First',
        $lastName = 'Last'
    ) : User {
        return new User(
            new Name(new FirstName($firstName), new LastName($lastName)),
            new Username($username),
            new Email($email),
            new Address(
                new City($city),
                new Country('DE'),
                new ZipCode('12345'),
                new Street('Test'),
                new HouseNumber('123abc')
            ),
            new Password('1234'),
            new Location(1.23456789, 9.87654321),
            new PhoneNumber('+123456789')
        );
    }

    public static function userCollection() : UserCollection
    {
        $users = new UserCollection();
        $users->add(self::user());

        return $users;
    }
}
