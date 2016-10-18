<?php
declare (strict_types = 1);

namespace BenHx\Api\Services;


use BenHx\Api\Util\ApiResponse;
use BenHx\Api\Util\HttpStatusCode;
use Psr\Http\Message\ServerRequestInterface;

class ErrorService
{
    public function responseFromException(ServerRequestInterface $request, ApiResponse $response, \Exception $exception) {
        switch (get_class($exception)) {
            case 'BenHx\Api\Exceptions\ValidationException':
                return $response->withStatus(HttpStatusCode::BAD_REQUEST)->withException($exception);
                break;
            case 'BenHx\Api\Exceptions\UnauthorizedException':
                return $response->withStatus(HttpStatusCode::UNAUTHORIZED)->withException($exception);
                break;
            default:
                return $response->withStatus(HttpStatusCode::INTERNAL_SERVER_ERROR)->withException($exception);
        }
    }
}