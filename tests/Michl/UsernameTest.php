<?php

declare (strict_types = 1);

namespace Mihaeu\Hotshowers;

/**
 * @covers Mihaeu\Hotshowers\Username
 */
class UsernameTest extends \PHPUnit_Framework_TestCase
{
    public function testHasUserName()
    {
        $this->assertEquals('test', new Username('test'));
        $this->assertEquals('test', (new Username('test'))->toString());
    }
}
