<?php

declare (strict_types = 1);

namespace BenHx\Api\Test\Models\User;

use BenHx\Api\Models\User\User;
use BenHx\Api\Exceptions\ValidationException;


class UserTest extends \PHPUnit_Framework_TestCase
{
    public function testThatPropertiesIncludingPasswordAreValid()
    {
        $id = "user";
        $username = "user";
        $password = '1234';
        $firstName = 'testfirstname';
        $lastName = 'testlastname';
        $email = 'test@test.com';
        $user = new User($id, $username, $password, $firstName, $lastName, $email);
        $this->assertEquals($user->getUsername(), $username);
        $this->assertEquals($user->getFirstName(), $firstName);
        $this->assertEquals($user->getLastName(), $lastName);
        $this->assertEquals($user->getEmail(), $email);
        $this->assertTrue($user->verifyPassword($password));
    }

    public function testThatWrongEmailThrowsValidationException()
    {
        $this->expectException(ValidationException::class);
        $id = "user";
        $username = "user";
        $password = '1234';
        $firstName = 'testfirstname';
        $lastName = 'testlastname';
        $email = 'wrongmail';
        $user = new User($id, $username, $password, $firstName, $lastName, $email);
    }
}