<?php

declare (strict_types = 1);

namespace BenHx\Api\Test\Integration\Authentication;

use BenHx\Api\Test\Helpers\BaseRequestTestCase;
use BenHx\Api\Test\Helpers\IntegrationBaseTestCase;
use BenHx\Api\Test\Helpers\UtilTestHelper;
use BenHx\Api\Test\Helpers\ExampleDictionaries;
use BenHx\Api\Util\HttpStatusCode;

class RegisterTest extends IntegrationBaseTestCase
{
    protected function setUp()
    {
        UtilTestHelper::truncateDB();
    }

    public function testShouldReturnAUserAndTokenWhenPostingAValidUser()
    {
        $response = $this->postExampleUser(ExampleDictionaries::$bobUser);
        $jsonResponse = json_decode($response->getBody()->getContents(), true);
        //print_r($jsonResponse);

        $this->assertEquals(HttpStatusCode::CREATED, $response->getStatusCode());
        $this->assertTrue($jsonResponse['success']);

        $this->evaluateUserResponse($jsonResponse['data']['user'], ExampleDictionaries::$bobUser);
        $this->evaluateTokenResponse($jsonResponse['data']['token'], ExampleDictionaries::$bobUser);
    }

    public function testShouldReturnAUserAndTokenWhenPostingAMinimalUser()
    {
        $response = $this->postExampleUser(ExampleDictionaries::$minimalUser);
        $jsonResponse = json_decode($response->getBody()->getContents(), true);

        $this->assertEquals(HttpStatusCode::CREATED, $response->getStatusCode());
        $this->assertTrue($jsonResponse['success']);

        $this->assertArrayHasKey('id', $jsonResponse['data']['user']);
        $this->assertArrayHasKey('username', $jsonResponse['data']['user']);

        $this->assertArrayNotHasKey('password', $jsonResponse['data']['user']);

        $this->assertEquals($jsonResponse['data']['user']['username'], ExampleDictionaries::$minimalUser['username']);
        $this->evaluateTokenResponse($jsonResponse['data']['token'], ExampleDictionaries::$minimalUser);
    }

    public function testShouldReturnABadRequestWhenPostingAUserWithNoCredentials()
    {
        $response = $this->postExampleUser([]);
        $this->evaluateErrorResponse(HttpStatusCode::BAD_REQUEST, $response);
    }

    public function testShouldReturnABadRequestWhenPostingAUserWithNoUsername()
    {
        $response = $this->postExampleUser(['password' => 'testpassword']);
        $this->evaluateErrorResponse(HttpStatusCode::BAD_REQUEST, $response);
    }

    public function testShouldReturnABadRequestWhenPostingAUserWithNoPassword()
    {
        $response = $this->postExampleUser(['username' => 'testusername']);
        $this->evaluateErrorResponse(HttpStatusCode::BAD_REQUEST, $response);
    }

    public function testShouldReturnABadRequestWhenPostingTwoUsersWithTheSameUsername()
    {
        $this->postExampleUser(ExampleDictionaries::$bobUser);
        $response = $this->postExampleUser(ExampleDictionaries::$bobUser);
        $this->evaluateErrorResponse(HttpStatusCode::BAD_REQUEST, $response);
    }

}