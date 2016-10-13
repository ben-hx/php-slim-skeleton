<?php

declare (strict_types = 1);

namespace Mihaeu\Hotshowers\Message;

use Mihaeu\Hotshowers\User;

class Message
{
    /** @var Subject */
    private $subject;

    /** @var Body */
    private $body;

    /** @var User */
    private $from;

    /** @var User */
    private $to;

    /**
     * @param Subject $subject
     * @param Body    $body
     * @param User    $from
     * @param User    $to
     */
    public function __construct(Subject $subject, Body $body, User $from, User $to)
    {
        $this->subject = $subject;
        $this->body = $body;
        $this->from = $from;
        $this->to = $to;
    }

    /**
     * @return Subject
     */
    public function subject() : Subject
    {
        return $this->subject;
    }

    /**
     * @return Body
     */
    public function body() : Body
    {
        return $this->body;
    }

    /**
     * @return User
     */
    public function from() : User
    {
        return $this->from;
    }

    /**
     * @return User
     */
    public function to() : User
    {
        return $this->to;
    }
}
