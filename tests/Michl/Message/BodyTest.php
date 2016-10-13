<?php

declare (strict_types = 1);

namespace Mihaeu\Hotshowers\Message;

/**
 * @covers Mihaeu\Hotshowers\Message\Body
 */
class BodyTest extends \PHPUnit_Framework_TestCase
{
    public function testHasBody()
    {
        $this->assertEquals('body', (new Body('body'))->toString());
        $this->assertEquals('body', (new Body('body')));
    }
}
