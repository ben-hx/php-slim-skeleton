<?php
/**
 * Created by PhpStorm.
 * User: ben-hx
 * Date: 12.10.2016
 * Time: 17:31
 */

namespace BenHx\Api\Helpers;


class UtilTestHelper
{
    public static function unlinkFile($fileName)
    {
        $tmp = dirname(__FILE__);
        if (strpos($tmp, '/', 0)!==false) {
            $windowsServer = false;
        } else {
            $windowsServer = true;
        }
        if (!$windowsServer) {
            if (!unlink($fileName)) {
                $deleteError = 1;
            }
        } else {
            $lines = array();
            exec("DEL /F/Q \"$fileName\"", $lines, $deleteError);
        }
    }
}