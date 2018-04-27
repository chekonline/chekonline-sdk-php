<?php

namespace Chekonline\Cashbox;

/**
 * Class DocumentType тип документа
 * @package Chekonline\Cashbox
 */
class DocumentType
{
    /**
     * Приход
     */
    const DEBIT = 0;
    /**
     * Расход
     */
    const CREDIT = 1;
    /**
     * Возврат прихода
     */
    const REFUND_DEBIT = 2;
    /**
     * Возврат расхода
     */
    const REFUND_CREDIT = 3;
}