<?php

namespace Chekonline\Cashbox;


/**
 * Class TaxId
 *
 * @package Chekonline\Cashbox
 */
class TaxId
{
    /**
     * НДС 18%
     */
    const TAX_18 = 1;

    /**
     * НДС 20%
     */
    const TAX_20 = 1;
    /**
     * НДС 10%
     */
    const TAX_10 = 2;
    /**
     * НДС 0%
     */
    const TAX_0 = 3;
    /**
     * Без налога
     */
    const TAX_NULL = 4;
    /**
     * Ставка 18/118
     */
    const TAX_18_118 = 5;
    /**
     * Ставка 20/120
     */
    const TAX_20_120 = 5;
    /**
     * Ставка 10/110
     */
    const TAX_10_110 = 6;

    /**
     * @var array
     */
    public static $dictionary = [
        self::TAX_18     => 'НДС 18%',
        self::TAX_20     => 'НДС 20%',
        self::TAX_10     => 'НДС 10%',
        self::TAX_0      => 'НДС 0%',
        self::TAX_NULL   => 'Без налога',
        self::TAX_18_118 => 'Ставка 18/118',
        self::TAX_20_120 => 'Ставка 20/120',
        self::TAX_10_110 => 'Ставка 10/110',
    ];
}