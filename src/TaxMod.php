<?php

namespace Chekonline\Cashbox;


/**
 * Class TaxMod система налогообложения
 * @package Chekonline\Cashbox
 */
class TaxMod
{
    /**
     * Общая
     */
    const TAX_0 = 1;
    /**
     * Упрощённая доход
     */
    const TAX_1 = 2;
    /**
     * Упрощённая доход минус расход
     */
    const TAX_2 = 4;
    /**
     * Единый налог на вменённый доход
     */
    const TAX_3 = 8;
    /**
     * Единый сельскохозяйственный налог
     */
    const TAX_4 = 16;
    /**
     * Патентная система налогообложения
     */
    const TAX_5 = 32;

    /**
     * @var array
     */
    public static $dictionary = array(
        self::TAX_0 => 'Общая',
        self::TAX_1 => 'Упрощённая доход',
        self::TAX_2 => 'Упрощённая доход минус расход',
        self::TAX_3 => 'Единый налог на вменённый доход',
        self::TAX_4 => 'Единый сельскохозяйственный налог',
        self::TAX_5 => 'Патентная система налогообложения',
    );
}