<?php

declare (strict_types = 1);

namespace BenHx\Api\Controllers\User;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Interop\Container\ContainerInterface;

class UserController
{
    protected $ci;
    //Constructor
    public function __construct(ContainerInterface $ci) {
        $this->ci = $ci;
    }

    /**
     * @SWG\Post(path="/register",
     *   tags={"user", "register"},
     *   summary="Register user",
     *   description="Register an new User",
     *   operationId="registerUser",
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
    public function register(ServerRequestInterface $request, ResponseInterface $response, $next)
    {
        return $response->withStatus(200)->write('Hello World!');
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
    public function login()
    {
    }

    /**
     * @SWG\Get(path="/logout",
     *   tags={"user"},
     *   summary="Logs out current logged in user session",
     *   description="",
     *   operationId="logoutUser",
     *   produces={"application/json"},
     *   parameters={},
     *   @SWG\Response(response="default", description="successful operation")
     * )
     */
    public function logout()
    {
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
