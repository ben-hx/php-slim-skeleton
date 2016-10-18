<?php

declare (strict_types = 1);

namespace BenHx\Api\Test\Helpers;

use BenHx\Api\Util\HttpStatusCode;
use GuzzleHttp;


abstract class IntegrationBaseTestCase extends \PHPUnit_Framework_TestCase
{
    protected static $httpClient;

    public static function setUpBeforeClass()
    {
        UtilTestHelper::truncateDB();
        self::$httpClient = new GuzzleHttp\Client(UtilTestHelper::getGuzzleDefaultConfig());
    }

    public static function tearDownAfterClass()
    {
        //UtilTestHelper::truncateDB();
    }

    protected function postExampleUser($user) {
        return self::$httpClient->post('/register', ['json' => $user]);
    }

    protected function evaluateBadRequestResponse($response) {
        $jsonResponse = json_decode($response->getBody()->getContents(), true);
        $this->assertEquals(HttpStatusCode::BAD_REQUEST, $response->getStatusCode());
        $this->assertFalse($jsonResponse['success']);
        $this->assertArrayHasKey('error', $jsonResponse);
    }

    protected function evaluateUnauthorizedResponse($response) {
        $jsonResponse = json_decode($response->getBody()->getContents(), true);
        $this->assertEquals(HttpStatusCode::UNAUTHORIZED, $response->getStatusCode());
        $this->assertFalse($jsonResponse['success']);
        $this->assertArrayHasKey('error', $jsonResponse);
    }

    protected function evaluateUserResponse($response, $user) {
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('username', $response);
        $this->assertArrayHasKey('firstname', $response);
        $this->assertArrayHasKey('lastname', $response);
        $this->assertArrayHasKey('email', $response);

        $this->assertArrayNotHasKey('password', $response);

        $this->assertEquals($response['username'], $user['username']);
        $this->assertEquals($response['firstname'], $user['firstName']);
        $this->assertEquals($response['lastname'], $user['lastName']);
        $this->assertEquals($response['email'], $user['email']);
    }

    protected function evaluateTokenResponse($token, $user) {
        $this->assertTrue(UtilTestHelper::validateToken($token, $user['username']));
    }

}