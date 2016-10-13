<?php

declare (strict_types = 1);

namespace Mihaeu\Hotshowers;

/**
 * @covers Mihaeu\Hotshowers\Name
 *
 * @covers Mihaeu\Hotshowers\FirstName
 * @covers Mihaeu\Hotshowers\LastName
 */
class NameTest extends \PHPUnit_Framework_TestCase
{
    /** @var Name */
    private $name;

    public function setUp()
    {
        $this->name = new Name(new FirstName('First'), new LastName('Last'));
    }

    public function testHasFirstName()
    {
        $this->assertEquals(new FirstName('First'), $this->name->firstName());
    }

    public function testHasLastName()
    {
        $this->assertEquals(new LastName('Last'), $this->name->lastName());
    }

    public function testToString()
    {
        $this->assertEquals('First Last', $this->name);
    }
}
