<?php

declare (strict_types = 1);

namespace Mihaeu\Hotshowers;

class ZipCode
{
    /** @var string */
    private $zipCode;

    /**
     * @param string $zipCode
     */
    public function __construct(string $zipCode)
    {
        $this->zipCode = $zipCode;
    }

    /**
     * @return string
     */
    public function toString() : string
    {
        return $this->zipCode;
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return $this->toString();
    }
}
