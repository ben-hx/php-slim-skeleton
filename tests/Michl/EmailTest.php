<?php

declare (strict_types = 1);

namespace Mihaeu\Hotshowers;

/**
 * @covers Mihaeu\Hotshowers\Email
 */
class EmailTest extends \PHPUnit_Framework_TestCase
{
    public function testHasAddress()
    {
        $this->assertEquals('test@test.com', new Email('test@test.com'));
        $this->assertEquals('test@test.com', (new Email('test@test.com'))->toString());
    }
}
