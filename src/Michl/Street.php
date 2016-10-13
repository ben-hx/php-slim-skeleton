<?php

declare (strict_types = 1);

namespace Mihaeu\Hotshowers;

class Street
{
    /** @var string */
    private $street;

    /**
     * @param string $street
     */
    public function __construct($street)
    {
        $this->street = $street;
    }

    /**
     * @return string
     */
    public function toString() : string
    {
        return $this->street;
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return $this->toString();
    }
}
