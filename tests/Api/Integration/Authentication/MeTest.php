<?php
declare (strict_types = 1);

namespace BenHx\Api\Test\Integration\Authentication;

use BenHx\Api\Test\Helpers\IntegrationBaseTestCase;
use BenHx\Api\Test\Helpers\ExampleDictionaries;
use BenHx\Api\Test\Helpers\UtilTestHelper;
use BenHx\Api\Util\HttpStatusCode;

class MeTest extends IntegrationBaseTestCase
{
    protected function setUp()
    {
        UtilTestHelper::truncateDB();
    }

    protected function getMe($token) {
        return self::$httpClient->get('/me',  [
            'headers' => [
                'Authorization' => 'Bearer '.$token
            ],
        ]);
    }

    public function testShouldReturnUserWhenGettingMeWithCorrectTokenAuthentication()
    {
        $this->postExampleUser(ExampleDictionaries::$bobUser);
        $token = $this->getToken(ExampleDictionaries::$bobUser);

        $response = $this->getMe($token);
        $jsonResponse = json_decode($response->getBody()->getContents(), true);

        $this->assertEquals(HttpStatusCode::OK, $response->getStatusCode());
        $this->assertTrue($jsonResponse['success']);

        $this->evaluateUserResponse($jsonResponse['data']['user'], ExampleDictionaries::$bobUser);
    }

    public function testShouldReturnUnauthorizedWhenGettingMeWithInvalidToken()
    {
        $this->postExampleUser(ExampleDictionaries::$bobUser);
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE0NzY4NzE1NjcsImV4cCI6MTQ3Njg3ODc2NywianRpIjoiNkxpVTYyQzVhVU90MWtHSlh3WThxMCIsInN1YiI6InRlc3R1c2VybmFtZSJ9.lCdr3S5hYL1SlREvl7-yulYbrGEx6YfX5QJOJ1S4UPA';

        $response = $this->getMe($token);

        $this->evaluateErrorResponse(HttpStatusCode::UNAUTHORIZED, $response);
    }

}