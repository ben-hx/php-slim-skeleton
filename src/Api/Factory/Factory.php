<?php

declare (strict_types = 1);

namespace BenHx\Api\Factory;

use BenHx\Api\Exceptions\ValidationException;
use BenHx\Api\Util\ApiResponse;
use BenHx\Api\Util\HttpStatusCode;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Headers;
use BenHx\Api\Exceptions\FileNotWritableException;
use BenHx\Api\Models\User\UserFileRepository;
use Interop\Container\ContainerInterface;
use BenHx\Api\Controllers\Authentication\AuthenticationController;
/**
 * Created by PhpStorm.
 * User: ben-hx
 * Date: 14.10.2016
 * Time: 13:46
 */
class Factory
{
    private $config;
    private $dbBaseDirecotry;
    private $userRepositoryFileName = '\UserRepository';
    private $configPath = __DIR__.'\..\..\..\config.ini';

    public function __construct()
    {
        $this->config = parse_ini_file($this->configPath, true);
        $this->dbBaseDirecotry = $this->config[$this->config['application']['app_mode']]['db_base_dir'];
    }

    private function getFileInfoForFileName($fileNameWithPath)
    {
        $fileHandle = fopen($fileNameWithPath, 'a');
        if ($fileHandle) {
            fclose($fileHandle);
            return new \SplFileInfo($fileNameWithPath);
        } else {
            fclose($fileHandle);
            throw new FileNotWritableException();
        }
    }

    public function inizializeContainerDI(ContainerInterface $container)
    {
        $container['AuthenticationController'] = function ($container) {
            return new AuthenticationController($container['UserRepository']);
        };
        $container['UserRepository'] = function ($container) {
            return new UserFileRepository($this->getFileInfoForFileName($this->dbBaseDirecotry.$this->userRepositoryFileName));
        };
        $container['errorHandler'] = function ($container) {
            return function (ServerRequestInterface $request, ApiResponse $response, \Exception $exception) use ($container) {

                switch (get_class($exception)) {
                    case 'BenHx\Api\Exceptions\ValidationException':
                        return $container['response']->withStatus(HttpStatusCode::BAD_REQUEST)->withException($exception);
                        break;
                    default:
                        return $container['response']->withStatus(HttpStatusCode::INTERNAL_SERVER_ERROR)->write($exception);
                }

            };
        };
        $container['response'] = function ($container) {
            $headers = new Headers(['Content-Type' => 'application/json']);
            $response = new ApiResponse(HttpStatusCode::OK, $headers);
            return $response->withProtocolVersion($container->get('settings')['httpVersion']);
        };
    }


}