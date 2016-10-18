<?php

declare (strict_types = 1);

namespace BenHx\Api\Serializer;

use \BenHx\Api\Models\User\User;
use \BenHx\Api\Models\User\UserSerializer;
/**
 * Created by PhpStorm.
 * User: ben-hx
 * Date: 18.10.2016
 * Time: 12:37
 */
class RegisterSerializer extends UserSerializer
{

    private $token;

    /**
     * TokenSerializer constructor.
     * @param $token
     */
    public function __construct(User $userInstance, string $token)
    {
        parent::__construct($userInstance);
        $this->token = $token;
    }

    public function jsonSerialize() {
        $result = [];
        $json = parent::jsonSerialize();
        $result['user'] = $json;
        $result['token'] = $this->token;
        return $result;
    }
}