<?php

declare (strict_types = 1);

namespace BenHx\Api\Test\Helpers;


use BenHx\Api\Exceptions\FileNotWritableException;
use BenHx\Api\Models\User\User;
use Firebase\JWT\JWT;

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

    public static function validateToken(string $token, string $username) {
        $config = UtilTestHelper::getConfig();
        $secret = $config['application']['app_secret'];
        $algorithm = $config['application']['app_secret_algorithm'];
        $decoded = JWT::decode($token, $secret, array($algorithm));
        return $decoded->sub == $username;
    }

    public static function truncateUserRepository()
    {
        $config = UtilTestHelper::getConfig();
        $file = realpath($config['development']['db_base_dir'].DIRECTORY_SEPARATOR.'UserRepository');
        UtilTestHelper::setFileContentEmpty($file);
    }

    public static function truncateDB()
    {
        UtilTestHelper::truncateUserRepository();
    }
}