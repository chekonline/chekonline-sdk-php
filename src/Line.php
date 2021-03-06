<?php

namespace Chekonline\Cashbox;

use Chekonline\Cashbox\Exceptions\ChekonlineLineException;

class Line
{
    /**
     * Наименование товарной позиции.
     *
     * @var string
     */
    protected $Description = '';

    /**
     * Количество. Количество указывается в  тысячных долях, т.о если необходимо передать количество, например, 2,5
     * килограмма то в параметре следует указать 2500 (2,5 · 1000 = 2500)
     *
     * @var int
     */
    protected $Qty = 0;

    /**
     * Цена. Цена указывается в копейках
     *
     * @var int
     */
    protected $Price = 0;

    /**
     * Признак способа расчёта
     *
     * @var int
     */
    protected $PayAttribute;

    /**
     * Код налога
     *
     * @var int
     */
    protected $TaxId;

    /**
     * Сумма товарной позиции
     *
     * @var int
     */
    protected $SubTotal;

    /**
     * @var boolean
     */
    protected $isShipping = false;

    /**
     * Признак предмета расчёта
     *
     * @var int
     */
    protected $LineAttribute;

    /**
     * Line constructor.
     *
     * @param bool $isShipping
     */
    public function __construct($isShipping = false)
    {
        $this->setSipping($isShipping);
    }

    /**
     * @return array
     */
    public function getParam()
    {
        $param = get_object_vars($this);

        return $param;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->Description;
    }

    /**
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->Description = $description;

        return $this;
    }

    /**
     * @return int
     */
    public function getQty()
    {
        return $this->Qty;
    }

    /**
     * @param int $qty
     *
     * @return $this
     */
    public function setQty($qty)
    {
        $this->Qty = $qty;

        return $this;
    }

    /**
     * @return int
     */
    public function getPrice()
    {
        return $this->Price;
    }

    /**
     * @param int $price
     *
     * @return $this
     */
    public function setPrice($price)
    {
        $this->Price = $price;

        return $this;
    }

    /**
     * @return int
     */
    public function getPayAttribute()
    {
        return $this->PayAttribute;
    }

    /**
     * @param int $payAttribute
     *
     * @return $this
     */
    public function setPayAttribute($payAttribute)
    {
        $this->PayAttribute = $payAttribute;

        return $this;
    }

    /**
     * @return int
     */
    public function getTaxId()
    {
        return $this->TaxId;
    }

    /**
     * @param int $taxId
     *
     * @return $this
     */
    public function setTaxId($taxId)
    {
        $this->TaxId = $taxId;

        return $this;
    }

    /**
     * @param int $SubTotal
     *
     * @return Line
     */
    public function setSubTotal($SubTotal)
    {
        $this->SubTotal = $SubTotal;

        return $this;
    }

    /**
     * @return int
     */
    public function getSubTotal()
    {
        return $this->SubTotal;
    }

    /**
     * @throws ChekonlineLineException
     */
    public function validate()
    {
        if ($this->getDescription() == '') {
            throw new ChekonlineLineException('Receipt line must have a description', $this);
        }
        if ($this->getQty() <= 0) {
            throw new ChekonlineLineException('The qty of the line must be greater than zero', $this);
        }
        if ($this->getPrice() <= 0 && $this->getSubTotal() <= 0) {
            throw new ChekonlineLineException('The price of the product must be greater than zero', $this);
        }
        if (isset($this->PayAttribute) == false) {
            throw new ChekonlineLineException('The pay attribute must be determined', $this);
        }
        if (isset($this->TaxId) == false) {
            throw new ChekonlineLineException('The tax must be determined', $this);
        }
    }

    /**
     * @return bool
     */
    public function isShipping()
    {
        return $this->isShipping;
    }

    /**
     * @param bool $isSipping
     *
     * @return $this
     */
    public function setSipping($isSipping = true)
    {
        $this->isShipping = $isSipping;

        return $this;
    }

    /**
     * @return int
     */
    public function getLineAttribute()
    {
        return $this->LineAttribute;
    }

    /**
     * @param int $LineAttribute
     *
     * @return Line
     */
    public function setLineAttribute($LineAttribute)
    {
        $this->LineAttribute = intval($LineAttribute);

        return $this;
    }
}