<?php

declare (strict_types = 1);

namespace BenHx\Api\Util;


class BaseSerializer implements ApiSerializeable
{
    private $instance;

    public function __construct($instance)
    {
        $this->instance = $instance;
    }

    public function jsonSerialize()
    {
        $json = array();
        $r = new \ReflectionObject($this->instance);
        $methods = $r->getMethods();
        foreach ($methods as $method) {
            $property = $method->getName();
            if (stripos($property, "get") !== FALSE) {
                $property = mb_strtolower(mb_substr($property, 3, mb_strlen($property, 'UTF-8'), 'UTF-8'), 'UTF-8');
                $json[utf8_encode($property)] = utf8_encode($method->invoke($this->instance));
            }
        }
        return $json;
    }
}