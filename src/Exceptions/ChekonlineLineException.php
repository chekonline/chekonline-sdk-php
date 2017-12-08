<?php

namespace Chekonline\Cashbox\Exceptions;


class ChekonlineLineException extends ChekonlineSDKException
{
    /**
     * @var \Chekonline\Cashbox\Line
     */
    private $receiptLine;


    /**
     * ChekonlineLineException constructor.
     * @param string $message
     * @param \Chekonline\Cashbox\Line $receiptLine
     */
    public function __construct($message = "", $receiptLine = null)
    {
        $this->receiptLine = $receiptLine;
        parent::__construct($message);
    }

    /**
     * @return \Chekonline\Cashbox\Line
     */
    public function getReceiptLine()
    {
        return $this->receiptLine;
    }

}