<?php

declare (strict_types = 1);

namespace Message;

use Mihaeu\Hotshowers\Message\Subject;

/**
 * @covers Mihaeu\Hotshowers\Message\Subject
 */
class SubjectTest extends \PHPUnit_Framework_TestCase
{
    public function testHasSubject()
    {
        $this->assertEquals('important!', (new Subject('important!'))->toString());
        $this->assertEquals('important!', (new Subject('important!')));
    }
}
