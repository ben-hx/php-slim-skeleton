<?php

declare (strict_types = 1);

namespace BenHx\Api\Controllers\Authentication;

use BenHx\Api\Controllers\BaseController;
use BenHx\Api\Exceptions\MissingArgumentException;
use BenHx\Api\Exceptions\ValidationException;
use BenHx\Api\Models\User\UserRepository;
use BenHx\Api\Models\User\UserSerializer;
use BenHx\Api\Serializer\RegisterSerializer;
use BenHx\Api\Serializer\TokenSerializer;
use BenHx\Api\Services\AuthenticationService;
use BenHx\Api\Util\HttpStatusCode;
use BenHx\Api\Util\ApiResponse;
use BenHx\Api\Util\Util;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response;


class AuthenticationController extends BaseController
{
    protected $authenticationService;
    protected $userRepository;

    public function __construct(AuthenticationService $authenticationService, UserRepository $userRepository) {
        $this->authenticationService = $authenticationService;
        $this->userRepository = $userRepository;
    }

    /**
     * @SWG\Post(path="/register",
     *   tags={"user", "register"},
     *   summary="Register user",
     *   description="Register a new User",
     *   operationId="register",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="Created user object",
     *     required=false,
     *     @SWG\Schema(ref="#/definitions/User")
     *   ),
     *   @SWG\Response(response="default", description="successful operation")
     * )
     */
    public function register(ServerRequestInterface $request, ApiResponse $response)
    {
        try {
            $user = Util::callMethodFromArray($this->authenticationService, "register", $request->getParsedBody());
            $token = $this->authenticationService->getToken();
        } catch (MissingArgumentException $e) {
            throw new ValidationException($e->getParam().' is missing!');
        }
        return $response->withStatus(HttpStatusCode::CREATED)->withApiSerializeable(new RegisterSerializer($user, $token));
    }

    /**
     * @SWG\Get(path="/login",
     *   tags={"user"},
     *   summary="Logs user into the system",
     *   description="",
     *   operationId="loginUser",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     name="username",
     *     in="query",
     *     description="The user name for login",
     *     required=false,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="password",
     *     in="query",
     *     description="The password for login in clear text",
     *     required=false,
     *     type="string"
     *   ),
     *   @SWG\Response(
     *     response=200,
     *     description="successful operation",
     *     @SWG\Schema(type="string"),
     *     @SWG\Header(
     *       header="X-Rate-Limit",
     *       type="integer",
     *       format="int32",
     *       description="calls per hour allowed by the user"
     *     ),
     *     @SWG\Header(
     *       header="X-Expires-After",
     *       type="string",
     *       format="date-time",
     *       description="date in UTC when toekn expires"
     *     )
     *   ),
     *   @SWG\Response(response=400, description="Invalid username/password supplied")
     * )
     */
    public function token(ServerRequestInterface $request, ApiResponse $response)
    {
        $token = $this->authenticationService->getToken();
        return $response->withStatus(HttpStatusCode::CREATED)->withApiSerializeable(new TokenSerializer($token));
    }

    /**
     * @SWG\Put(path="/me",
     *   tags={"user"},
     *   summary="Updated user",
     *   description="This can only be done by the logged in user.",
     *   operationId="updateUser",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="Updated user object",
     *     required=false,
     *     @SWG\Schema(ref="#/definitions/User")
     *   ),
     *   @SWG\Response(response=400, description="Invalid user supplied"),
     *   @SWG\Response(response=404, description="User not found")
     * )
     */
    public function updateMe()
    {
    }
}
