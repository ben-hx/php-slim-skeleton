<?php

namespace BenHx\Api;

use BenHx\Api\Helpers\BaseRequestTestCase;
use BenHx\Api\Helpers\UtilTestHelper;
use BenHx\Api\Models\User\User;
use BenHx\Api\Models\User\UserSerializer;
use BenHx\Api\Util\HttpStatusCode;
use GuzzleHttp;

class AuthenticationControllerTest extends BaseRequestTestCase
{
    protected $client;

    protected function setUp()
    {
        $this->client = new GuzzleHttp\Client(UtilTestHelper::getGuzzleDefaultConfig());
        UtilTestHelper::truncateDB();
    }

    private $minimalUser = [
        'username' => 'minimal',
        'password' => 'minimalPassword',
    ];

    private $bobUser = [
        'username' => 'bob',
        'password' => 'bobPassword',
        'firstName' => 'bobFirstname',
        'lastName' => 'bobLastname',
        'email' => 'bob@mail.com'
    ];

    private $aliceUser = [
        'username' => 'alice',
        'password' => 'alicePassword',
        'firstName' => 'aliceFirstname',
        'lastName' => 'aliceLastname',
        'email' => 'alice@mail.com'
    ];

    private function postExampleUser($user) {
        return $this->client->post('/register', ['json' => $user]);
    }

    private function evaluateWrongCredentials($response) {
        $jsonResponse = json_decode($response->getBody(), true);
        $this->assertEquals(HttpStatusCode::BAD_REQUEST, $response->getStatusCode());
        $this->assertFalse($jsonResponse['success']);
        $this->assertArrayHasKey('error', $jsonResponse);
    }

    private function evaluateUserResponse($response, $user) {
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

    public function testShouldPostAValidUser()
    {
        $response = $this->postExampleUser($this->bobUser);
        $jsonResponse = json_decode($response->getBody(), true);

        $this->assertEquals(HttpStatusCode::CREATED, $response->getStatusCode());
        $this->assertTrue($jsonResponse['success']);

        $this->evaluateUserResponse($jsonResponse['data'], $this->bobUser);
    }

    public function testShouldPostAMinimalUser()
    {
        $response = $this->postExampleUser($this->minimalUser);
        $jsonResponse = json_decode($response->getBody(), true);

        $this->assertEquals(HttpStatusCode::CREATED, $response->getStatusCode());
        $this->assertTrue($jsonResponse['success']);

        $this->assertArrayHasKey('id', $jsonResponse['data']);
        $this->assertArrayHasKey('username', $jsonResponse['data']);

        $this->assertArrayNotHasKey('password', $jsonResponse['data']);

        $this->assertEquals($jsonResponse['data']['username'], $this->minimalUser['username']);
    }

    public function testShouldNotPostAUserWithNoCredentials()
    {
        $response = $this->postExampleUser([]);
        $this->evaluateWrongCredentials($response);
    }

    public function testShouldNotPostAUserWithNoUsername()
    {
        $response = $this->postExampleUser(['password' => 'testpassword']);
        $this->evaluateWrongCredentials($response);
    }

    public function testShouldNotPostAUserWithNoPassword()
    {
        $response = $this->postExampleUser(['username' => 'testusername']);
        $this->evaluateWrongCredentials($response);
    }

    public function testShouldNotPostTwoUserWithTheSameUsername()
    {
        $this->postExampleUser($this->bobUser);
        $response = $this->postExampleUser($this->bobUser);
        $this->evaluateWrongCredentials($response);
    }


}