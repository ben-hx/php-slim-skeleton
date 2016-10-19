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
class MeSerializer extends UserSerializer
{
    public function jsonSerialize() {
        $result = [];
        $json = parent::jsonSerialize();
        $result['user'] = $json;
        return $result;
    }
}