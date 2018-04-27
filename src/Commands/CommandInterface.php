<?php

namespace Chekonline\Cashbox\Commands;

interface CommandInterface
{
    /**
     * @return array
     */
    public function getParams();

    /**
     * @throws \Chekonline\Cashbox\Exceptions\ChekonlineCommandException
     */
    public function validate();
}