<?php

namespace Chekonline\Cashbox\Exceptions;


class ChekonlineCommandException extends ChekonlineSDKException
{
    /**
     * @var \Chekonline\Cashbox\Commands\BaseCommand
     */
    private $command;


    /**
     * ChekonlineLineException constructor.
     *
     * @param string $message
     * @param \Chekonline\Cashbox\Commands\BaseCommand $command
     */
    public function __construct($message = "", $command = null)
    {
        $this->command = $command;
        parent::__construct($message);
    }

    /**
     * @return \Chekonline\Cashbox\Commands\BaseCommand
     */
    public function getCommand()
    {
        return $this->command;
    }

}