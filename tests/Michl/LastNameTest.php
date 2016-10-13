<?php

declare (strict_types = 1);

namespace Mihaeu\Hotshowers;

/**
 * @covers Mihaeu\Hotshowers\LastName
 */
class LastNameTest extends \PHPUnit_Framework_TestCase
{
    public function testHasLastName()
    {
        $this->assertEquals('Last', new LastName('Last'));
        $this->assertEquals('Last', (new LastName('Last'))->toString());
    }
}
