<?php

declare (strict_types = 1);

namespace Mihaeu\Hotshowers\Message;

class Body
{
    /** @var string */
    private $body;

    /**
     * @param string $body
     */
    public function __construct(string $body)
    {
        $this->body = $body;
    }

    /**
     * @return string
     */
    public function toString() : string
    {
        return $this->body;
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return $this->toString();
    }
}
