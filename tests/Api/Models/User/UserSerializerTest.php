<?php
/**
 * Created by PhpStorm.
 * User: ben-hx
 * Date: 17.10.2016
 * Time: 14:15
 */

namespace BenHx\Api;

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