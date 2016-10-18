<?php

declare (strict_types = 1);

namespace BenHx\Api\Serializer;

use BenHx\Api\Util\BaseSerializer;

/**
 * Created by PhpStorm.
 * User: ben-hx
 * Date: 18.10.2016
 * Time: 12:37
 */
class TokenSerializer extends BaseSerializer
{
    private $token;

    /**
     * TokenSerializer constructor.
     * @param $token
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function jsonSerialize() {
        $result = [];
        $result['token'] = $this->token;
        return $result;
    }
}