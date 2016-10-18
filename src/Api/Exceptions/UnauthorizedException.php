<?php
/**
 * Created by PhpStorm.
 * User: ben-hx
 * Date: 18.10.2016
 * Time: 16:21
 */

namespace BenHx\Api\Exceptions;


class UnauthorizedException extends \Exception
{
    /**
     * UnauthorizedException constructor.
     */
    public function __construct(string $message, $code = 401)
    {
        parent::__construct($message, $code);
    }
}