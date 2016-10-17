<?php
/**
 * Created by PhpStorm.
 * User: ben-hx
 * Date: 17.10.2016
 * Time: 20:17
 */

namespace BenHx\Api\Exceptions;


class MissingArgumentException extends \Exception
{
    private $param;

    /**
     * MissingArgumentException constructor.
     * @param $param
     */
    public function __construct($param)
    {
        parent::__construct("Missing parameter ".$param);
        $this->param = $param;
    }

    /**
     * @return string
     */
    public function getParam(): string
    {
        return $this->param;
    }




}