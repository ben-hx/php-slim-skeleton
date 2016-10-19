<?php
declare (strict_types = 1);

namespace BenHx\Api\Test\Integration\Authentication;

use BenHx\Api\Test\Helpers\IntegrationBaseTestCase;
use BenHx\Api\Test\Helpers\ExampleDictionaries;
use BenHx\Api\Test\Helpers\UtilTestHelper;
use BenHx\Api\Util\HttpStatusCode;

class TokenTest extends IntegrationBaseTestCase
{
    protected function setUp()
    {
        UtilTestHelper::truncateDB();
    }

    public function testShouldReturnAValidTokenWhenPostingUserCredentials()
    {
        $this->postExampleUser(ExampleDictionaries::$bobUser);
        $response = $this->postToken(ExampleDictionaries::$bobUser);
        $jsonResponse = json_decode($response->getBody()->getContents(), true);

        $this->assertEquals(HttpStatusCode::CREATED, $response->getStatusCode());
        $this->assertTrue($jsonResponse['success']);

        $this->evaluateTokenResponse($jsonResponse['data']['token'], ExampleDictionaries::$bobUser);
    }

    public function testShouldReturnUnauthorizedWhenPostingFalseCredentials()
    {
        $badBob = ExampleDictionaries::$bobUser;
        $this->postExampleUser($badBob);
        $badBob['password'] = "falsepassword";
        $response = $this->postToken($badBob);
        $this->evaluateErrorResponse(HttpStatusCode::UNAUTHORIZED, $response);
    }

    public function testShouldReturnUnauthorizedWhenPostingUnknownUser()
    {
        $response = $this->postToken(ExampleDictionaries::$bobUser);
        $this->evaluateErrorResponse(HttpStatusCode::UNAUTHORIZED, $response);
    }
}