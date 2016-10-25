<?php

declare (strict_types = 1);

namespace BenHx\Api\Factory;

use BenHx\Api\Exceptions\UnauthorizedException;
use BenHx\Api\Services\ErrorService;
use Slim\App;
use Slim\Http\Headers;
use Slim\Middleware\JwtAuthentication;
use Slim\Middleware\HttpBasicAuthentication;
use Psr\Http\Message\ServerRequestInterface;
use BenHx\Api\Services\AuthenticationService;
use BenHx\Api\Util\ApiResponse;
use BenHx\Api\Util\HttpStatusCode;
use BenHx\Api\Exceptions\FileNotWritableException;
use BenHx\Api\Models\User\UserFileRepository;
use BenHx\Api\Controllers\Authentication\AuthenticationController;
/**
 * Created by PhpStorm.
 * User: ben-hx
 * Date: 14.10.2016
 * Time: 13:46
 */
class Factory
{
    private $app;
    private $dbBaseDirecotry;
    private $userRepositoryFileName = DIRECTORY_SEPARATOR.'UserRepository';
    private $configPath = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'config.ini';

    public function __construct(App $app)
    {
        $this->app = $app;
        $this->config = parse_ini_file($this->configPath, true);
        $this->dbBaseDirecotry = realpath($this->config[$this->config['application']['app_mode']]['db_base_dir']);
    }

    private function getFileInfoForFileName($fileNameWithPath)
    {
        $fileHandle = fopen($fileNameWithPath, 'a');
        if ($fileHandle) {
            fclose($fileHandle);
            return new \SplFileInfo($fileNameWithPath);
        } else {
            fclose($fileHandle);
            throw new FileNotWritableException($fileNameWithPath);
        }
    }

    private function unauthorizedErrorHandler($request, $response, $arguments) {
        $container = $this->app->getContainer();
        $container["ErrorService"]->responseFromException($request, $response, new UnauthorizedException(implode(",", $arguments)));
    }

    public function inizializeContainerDI()
    {
        $container = $this->app->getContainer();

        $container["HttpBasicAuthentication"] = function ($container) {
            return new HttpBasicAuthentication([
                "path" => "/token",
                "authenticator" => $container["AuthenticationService"],
                "error" => function (ServerRequestInterface $request, ApiResponse $response, array $arguments) {
                    $this->unauthorizedErrorHandler($request, $response, $arguments);
                }
            ]);
        };
        $container["token"] = function ($container) {
            return new Token;
        };
        $container["JwtAuthentication"] = function ($container) {
            return new JwtAuthentication([
                "path" => "/",
                "secret" => $this->config['application']['app_secret'],
                "algorithm" => $this->config['application']['app_secret_algorithm'],
                "passthrough" => ["/register", "/token"],
                "error" => function (ServerRequestInterface $request, ApiResponse $response, array $arguments) {
                    $this->unauthorizedErrorHandler($request, $response, $arguments);
                },
                "callback" => function ($request, $response, $arguments) use ($container) {
                    $container["AuthenticationService"]->setUserNameFromToken($arguments["decoded"]->sub);
                }
            ]);
        };
        $container["ErrorService"] = function ($container) {
            return new ErrorService();
        };
        $container['AuthenticationService'] = function ($container) {
            return new AuthenticationService($container['UserRepository'], $container["JwtAuthentication"]);
        };
        $container['AuthenticationController'] = function ($container) {
            return new AuthenticationController($container['AuthenticationService'], $container['UserRepository']);
        };
        $container['UserRepository'] = function ($container) {
            //return new UserFileRepository($this->getFileInfoForFileName($this->dbBaseDirecotry.$this->userRepositoryFileName));
            return new UserFileRepository(new \SplFileInfo('./db/evelopment/UserRepository'));
        };
        $container['errorHandler'] = function ($container) {
            return function (ServerRequestInterface $request, ApiResponse $response, \Exception $exception) use ($container) {

                switch (get_class($exception)) {
                    case 'BenHx\Api\Exceptions\ValidationException':
                        return $container['response']->withStatus(HttpStatusCode::BAD_REQUEST)->withException($exception);
                        break;
                    default:
                        return $container['response']->withStatus(HttpStatusCode::INTERNAL_SERVER_ERROR)->withException($exception);
                }

            };
        };
        $container['response'] = function ($container) {
            $headers = new Headers(['Content-Type' => 'application/json']);
            $response = new ApiResponse(HttpStatusCode::OK, $headers);
            return $response->withProtocolVersion($container->get('settings')['httpVersion']);
        };
    }

    public function inizializeMiddleware() {
        $this->app->add("HttpBasicAuthentication");
        $this->app->add("JwtAuthentication");
    }

}