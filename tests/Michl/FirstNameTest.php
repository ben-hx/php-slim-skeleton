<?php

declare (strict_types = 1);

namespace Mihaeu\Hotshowers;

/**
 * @covers Mihaeu\Hotshowers\FirstName
 */
class FirstNameTest extends \PHPUnit_Framework_TestCase
{
    public function testHasFirstName()
    {
        $this->assertEquals('First', new FirstName('First'));
        $this->assertEquals('First', (new FirstName('First'))->toString());
    }
}
