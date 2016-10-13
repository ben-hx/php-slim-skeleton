<?php

declare (strict_types = 1);

namespace Mihaeu\Hotshowers;

class Username
{
    /** @var string */
    private $username;

    /**
     * @param string $username
     */
    public function __construct(string $username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function toString() : string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return $this->toString();
    }
}
