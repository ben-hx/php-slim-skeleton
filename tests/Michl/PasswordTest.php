<?php

declare (strict_types = 1);

namespace Mihaeu\Hotshowers;

class PasswordTest extends \PHPUnit_Framework_TestCase
{
    public function testHasPassword()
    {
        $this->assertEquals('1234', new Password('1234'));
        $this->assertEquals('1234', (new Password('1234'))->toString());
    }
}
