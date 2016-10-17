<?php

declare (strict_types = 1);

namespace BenHx\Api\Models\User;


use BenHx\Api\Util\BaseSerializer;

class UserSerializer extends BaseSerializer
{
    private $userInstance;

    /**
     * UserSerializer constructor.
     * @param $userInstance
     */
    public function __construct(User $userInstance)
    {
        parent::__construct($userInstance);
    }

    public function jsonSerialize() {
        $json = parent::jsonSerialize();
        unset($json['password']);
        return $json;
    }

}