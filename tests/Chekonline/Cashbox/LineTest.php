<?php

namespace Chekonline\Cashbox;


class LineTest extends \PHPUnit_Framework_TestCase
{
    const LINE_ATTRIBUTE = 1;

    public function testGetLineAttribute()
    {

        $line = new Line();
        $line->setLineAttribute(self::LINE_ATTRIBUTE);

        $this->assertEquals(self::LINE_ATTRIBUTE, $line->getLineAttribute());
        $this->assertEquals(self::LINE_ATTRIBUTE, $line->getParam()['LineAttribute']);

    }

}
