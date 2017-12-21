<?php

namespace Chekonline\Cashbox;

use Chekonline\Cashbox\Exceptions\ChekonlineLineException;

class Line
{
	/**
	 * @var string
	 */
	protected $Description = '';

	/**
	 * @var int
	 */
	protected $Qty = 0;

	/**
	 * @var int
	 */
	protected $Price = 0;

	/**
	 * @var int|null
	 */
	protected $PayAttribute;

	/**
	 * @var int|null
	 */
	protected $TaxId;

    /**
     * @var int|null
     */
	protected $SubTotal;

    /**
     * @var boolean
    */
    protected $isShipping = false;

    /**
     * Line constructor.
     * @param bool $isShipping
     */
    public function __construct ($isShipping = false)
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
	 * @return $this
	 */
	public function setPrice($price)
	{
		$this->Price = $price;
		return $this;
	}

	/**
	 * @return int|null
	 */
	public function getPayAttribute()
	{
		return $this->PayAttribute;
	}

	/**
	 * @param int $payAttribute
	 * @return $this
	 */
	public function setPayAttribute($payAttribute)
	{
		$this->PayAttribute = $payAttribute;
		return $this;
	}

	/**
	 * @return int|null
	 */
	public function getTaxId()
	{
		return $this->TaxId;
	}

	/**
	 * @param int $taxId
	 * @return $this
	 */
	public function setTaxId($taxId)
	{
		$this->TaxId = $taxId;
		return $this;
	}

    /**
     * @param int|null $SubTotal
     * @return Line
     */
    public function setSubTotal ($SubTotal)
    {
        $this->SubTotal = $SubTotal;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getSubTotal ()
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
        if ($this->getPrice() <= 0 && $this->getSubTotal() <= 0 ) {
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
     */
    public function setSipping($isSipping = true)
    {
        $this->isShipping = $isSipping;
    }
}