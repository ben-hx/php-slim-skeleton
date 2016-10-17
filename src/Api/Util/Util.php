<?php
/**
 * Created by PhpStorm.
 * User: ben-hx
 * Date: 17.10.2016
 * Time: 19:03
 */

namespace BenHx\Api\Util;

use BenHx\Api\Exceptions\MissingArgumentException;
use ReflectionMethod;
use Exception;

class Util
{
    public static function getRandomId() {
        return uniqid();
    }

    public static function callMethodFromArray($obj, $method, $arr){
        $ref = new ReflectionMethod($obj, $method);
        $params = [];
        foreach( $ref->getParameters() as $p ){
            if( $p->isOptional() ){
                if( isset($arr[$p->name]) ){
                    $params[] = $arr[$p->name];
                }else{
                    $params[] = $p->getDefaultValue();
                }
            }else if( isset($arr[$p->name]) ){
                $params[] = $arr[$p->name];
            }else{
                throw new MissingArgumentException($p->name);
            }
        }
        return $ref->invokeArgs($obj, $params );
    }
}