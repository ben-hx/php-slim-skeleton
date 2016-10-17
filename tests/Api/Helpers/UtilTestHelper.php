<?php
/**
 * Created by PhpStorm.
 * User: ben-hx
 * Date: 12.10.2016
 * Time: 17:31
 */

namespace BenHx\Api\Helpers;


use BenHx\Api\Exceptions\FileNotWritableException;

class UtilTestHelper
{
    private static function setFileContentEmpty($fileNameWithPath)
    {
        $fileHandle = fopen($fileNameWithPath, 'w');
        if (!$fileHandle) {
            fclose($fileHandle);
            throw new FileNotWritableException();
        }
        $stringData = "";
        fwrite($fileHandle, $stringData);
        fclose($fileHandle);
    }

    private static function getConfig(): array
    {
        return parse_ini_file('config.ini', true);
    }

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

    public static function getGuzzleDefaultConfig()
    {
        $config = UtilTestHelper::getConfig();
        return [
            'base_uri' => $config['development']['app_base_url'],
            'http_errors' => false
        ];
    }

    public static function truncateUserRepository()
    {
        $config = UtilTestHelper::getConfig();
        UtilTestHelper::setFileContentEmpty($config['development']['db_base_dir'].'\UserRepository');
    }

    public static function truncateDB()
    {
        UtilTestHelper::truncateUserRepository();
    }
}