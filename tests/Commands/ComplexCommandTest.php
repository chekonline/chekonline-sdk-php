<?php

namespace Tests\Chekonline\Cashbox\Commands;

use Chekonline\Cashbox\Commands\ComplexCommand;
use Chekonline\Cashbox\Line;

class ComplexCommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider normalizeDataProvider
     */
    public function testNormalizeByQty($lines, $amount)
    {
        $command = new ComplexCommand('test');

        foreach ($lines as $line) {
            $line = new Line();
            $line->setSubTotal($line['subTotal'])
                ->setDescription('test')
                ->setTaxId(1)
                ->setPayAttribute(1)
                ->setQty($line['qty']);
            $command->addLine($line);
        }
        $command->normalizeByQty($amount);

        /** @var Line $line */
        foreach ($command->getLines() as $line) {
            $line->validate();
        }

        $this->assertEquals($amount, $command->getAmount());

    }

    /**
     * @dataProvider normalizeDataProvider
     */
    public function testNormalizeBySubTotal($lines, $amount, $withShipping = false)
    {
        $command = new ComplexCommand('test');

        foreach ($lines as $line) {
            $isShipping = false;
            if (isset($line['shipping']) === true) {
                $isShipping = $line['shipping'];
            }
            $line = new Line($isShipping);

            $line->setSubTotal($line['subTotal'])
                ->setDescription('test')
                ->setTaxId(1)
                ->setPayAttribute(1)
                ->setQty($line['qty']);
            $command->addLine($line);
        }
        $command->normalizeBySubTotal($amount, $withShipping);

        /** @var Line $line */
        foreach ($command->getLines() as $line) {
            $line->validate();
        }

        $this->assertEquals($amount, $command->getAmount(true));

    }

    /**
     * @return array
     */
    public function normalizeDataProvider()
    {
        return array(

            array(
                array(
                    array('subTotal' => 10000, 'qty' => 1000),
                    array('subTotal' => 6017, 'qty' => 1000),
                    array('subTotal' => 12036, 'qty' => 1000, 'shipping' => true),
                ),
                27053,
                false,
            ),
            array(
                array(
                    array('subTotal' => 100, 'qty' => 1000),
                    array('subTotal' => 100, 'qty' => 1000),
                    array('subTotal' => 100, 'qty' => 1000, 'shipping' => true),
                ),
                500,
                true,
            ),

            array(
                array(
                    array('subTotal' => 100, 'qty' => 1000),
                    array('subTotal' => 100, 'qty' => 1000),
                    array('subTotal' => 100, 'qty' => 1000, 'shipping' => true),
                ),
                500,
                true,
            ),

            array(
                array(
                    array('subTotal' => 1, 'qty' => 1000),
                    array('subTotal' => 15, 'qty' => 1000),
                ),
                3,
                true,
            ),

            array(
                array(
                    array('subTotal' => 1000, 'qty' => 1000),
                    array('subTotal' => 1000, 'qty' => 1000),
                ),
                980,
                true,
            ),

            array(
                array(
                    array('subTotal' => 1000, 'qty' => 1000),
                    array('subTotal' => 2000, 'qty' => 1000),
                ),
                2900,
                true,
            ),

            array(
                array(
                    array('subTotal' => 5000, 'qty' => 1000),
                    array('subTotal' => 2000, 'qty' => 1000),
                ),
                10000,
                true,
            ),

            array(
                array(
                    array('subTotal' => 300, 'qty' => 1000),
                    array('subTotal' => 300, 'qty' => 1000),
                    array('subTotal' => 300, 'qty' => 1000),
                ),
                1000,
                true,
            ),

            array(
                array(
                    array('subTotal' => 300, 'qty' => 1000),
                    array('subTotal' => 200, 'qty' => 1000),
                    array('subTotal' => 100, 'qty' => 1000),
                ),
                500,
                true,
            ),

            array(
                array(
                    array('subTotal' => 100, 'qty' => 1000),
                ),
                90,
                true,
            ),

            array(
                array(
                    array('subTotal' => 100, 'qty' => 1000),
                    array('subTotal' => 100, 'qty' => 1000),
                    array('subTotal' => 100, 'qty' => 1000),
                ),
                300,
                true,
            ),

            array(
                array(
                    array('subTotal' => 100, 'qty' => 1000),
                    array('subTotal' => 100, 'qty' => 1000),
                    array('subTotal' => 100, 'qty' => 1000),
                ),
                500,
                true,
            ),

        );
    }
}
