<?php

declare (strict_types = 1);

namespace Mihaeu\Hotshowers;

class Email
{
    /** @var string */
    private $address;

    /**
     * @param string $address
     */
    public function __construct(string $address)
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function toString() : string
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return $this->toString();
    }
}
