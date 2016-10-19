<?php

declare (strict_types = 1);

namespace BenHx\Api\Test\Unit\Models\User;

use BenHx\Api\Models\User\User;
use BenHx\Api\Models\User\UserSerializer;

class UserSerializerTest extends \PHPUnit_Framework_TestCase
{
    public function testThatJSONSerializationExcludesPasswordProperty()
    {
        $id = "user";
        $username = "user";
        $password = '1234';
        $firstName = 'testfirstname';
        $lastName = 'testlastname';
        $email = 'test@test.com';
        $user = new User($id, $username, $password, $firstName, $lastName, $email);

        $serializer = new UserSerializer($user);
        $json = $serializer->jsonSerialize();

        $this->assertArrayHasKey('id', $json);
        $this->assertArrayHasKey('username', $json);
        $this->assertArrayHasKey('firstname', $json);
        $this->assertArrayHasKey('lastname', $json);
        $this->assertArrayHasKey('email', $json);

        $this->assertArrayNotHasKey('password', $json);

        $this->assertEquals($json['id'], $id);
        $this->assertEquals($json['username'], $username);
        $this->assertEquals($json['firstname'], $firstName);
        $this->assertEquals($json['lastname'], $lastName);
        $this->assertEquals($json['email'], $email);
    }

}