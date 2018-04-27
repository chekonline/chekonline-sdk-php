<?php

namespace Chekonline\Cashbox\Commands;

use Chekonline\Cashbox\Exceptions\ChekonlineCommandException;
use Chekonline\Cashbox\Line;

class ComplexCommand extends BaseCommand
{

    /**
     * @const string command name
     */
    const NAME = 'Complex';

    /**
     * @var int
     */
    private $Cash = 0;

    /**
     * @var array
     */
    private $NonCash = array([0, 0, 0]);

    /**
     * @var int|null
     */
    private $TaxMode;

    /**
     * @var string
     */
    private $PhoneOrEmail = '';

    /**
     * @var Line[]
     */
    private $Lines = array();

    /**
     * @var int
     */
    private $MaxDocumentsInTurn = 20;

    /**
     * @var int|null
     */
    private $DocumentType;

    /**
     * @var string
     */
    private $Device = 'auto';

    /**
     * @var int|null
     */
    private $Password;

    /**
     * @var string
     */
    private $Group = '';

    /**
     * @var bool
     */
    private $FullResponse = false;

    /**
     * ComplexCommand constructor.
     *
     * @param $requestId
     */
    public function __construct($requestId)
    {
        parent::__construct($requestId);
    }

    /**
     * @return array
     */
    public function getParams()
    {
        $baseParams = parent::getParams();
        $params     = array_merge(get_object_vars($this), $baseParams);

        /** @var Line $line */
        foreach ($this->Lines as $line) {
            $lines[] = $line->getParam();
        }
        $params['Lines'] = $lines;

        return $params;
    }

    /**
     * @return int
     */
    public function getCash()
    {
        return $this->Cash;
    }

    /**
     * @param int $cash
     *
     * @return $this
     */
    public function setCash($cash)
    {
        $this->Cash = $cash;

        return $this;
    }

    /**
     * @return array
     */
    public function getNonCash()
    {
        return $this->NonCash;
    }

    /**
     * @param array $nonCash
     *
     * @return $this
     */
    public function setNonCash($nonCash)
    {
        $this->NonCash = $nonCash;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getTaxMode()
    {
        return $this->TaxMode;
    }

    /**
     * @param int $taxMode
     *
     * @return $this
     */
    public function setTaxMode($taxMode)
    {
        $this->TaxMode = $taxMode;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhoneOrEmail()
    {
        return $this->PhoneOrEmail;
    }

    /**
     * @param string $contact
     *
     * @return $this
     */
    public function setPhoneOrEmail($contact)
    {
        $this->PhoneOrEmail = $contact;

        return $this;
    }

    /**
     * @return array
     */
    public function getLines()
    {
        return $this->Lines;
    }

    /**
     * @param Line $line
     */
    public function addLine($line)
    {
        $this->Lines[] = $line;
    }

    /**
     * @param int $MaxDocumentsInTurn
     *
     * @return $this
     */
    public function setMaxDocumentsInTurn($MaxDocumentsInTurn)
    {
        $this->MaxDocumentsInTurn = $MaxDocumentsInTurn;

        return $this;
    }

    /**
     * @return int
     */
    public function getMaxDocumentsInTurn()
    {
        return $this->MaxDocumentsInTurn;
    }

    /**
     * @param mixed $DocumentType
     *
     * @return $this
     */
    public function setDocumentType($DocumentType)
    {
        $this->DocumentType = $DocumentType;

        return $this;
    }

    /**
     * @return int
     */
    public function getDocumentType()
    {
        return $this->DocumentType;
    }

    /**
     * @param string $Device
     *
     * @return $this
     */
    public function setDevice($Device)
    {
        $this->Device = $Device;

        return $this;
    }

    /**
     * @return string
     */
    public function getDevice()
    {
        return $this->Device;
    }

    /**
     * @param int $Password
     *
     * @return $this
     */
    public function setPassword($Password)
    {
        $this->Password = $Password;

        return $this;
    }

    /**
     * @return int
     */
    public function getPassword()
    {
        return $this->Password;
    }

    /**
     * @param string $Group
     *
     * @return $this
     */
    public function setGroup($Group)
    {
        $this->Group = $Group;

        return $this;
    }

    /**
     * @return string
     */
    public function getGroup()
    {
        return $this->Group;
    }

    /**
     * @param bool $FullResponse
     *
     * @return $this
     */
    public function setFullResponse($FullResponse)
    {
        $this->FullResponse = $FullResponse;

        return $this;
    }

    /**
     * @return bool
     */
    public function isFullResponse()
    {
        return $this->FullResponse;
    }

    /**
     * {@inheritdoc}
     */
    public function validate()
    {
        parent::validate();
        if (isset($this->Password) == false) {
            throw new ChekonlineCommandException('The password must be determined', $this);
        }
        if (isset($this->DocumentType) == false) {
            throw new ChekonlineCommandException('The DocumentType must be determined', $this);
        }
        if (empty($this->Lines) == true) {
            throw new ChekonlineCommandException('The list of lines empty', $this);
        }
        if (isset($this->TaxMode) == false) {
            throw new ChekonlineCommandException('The tax mod must be determined', $this);
        }
    }

    /**
     * @param bool $withShipping
     *
     * @return int
     */
    public function getAmount($withShipping = false)
    {
        $amount = 0;
        foreach ($this->Lines as $line) {
            if ($line->isShipping() === true && $withShipping === false) {
                continue;
            }
            $amount = $amount + $line->getSubTotal();
        }

        return $amount;
    }

    /**
     * @return int
     */
    public function getSippingAmount()
    {
        $amount = 0;
        foreach ($this->Lines as $line) {
            if ($line->isShipping() === false) {
                continue;
            }
            $amount = $amount + $line->getSubTotal();
        }

        return $amount;
    }


    /**
     * @return int
     */
    public function getQty()
    {
        $qty = 0;
        foreach ($this->Lines as $line) {
            $qty = $qty + $line->getQty();
        }

        return $qty;
    }

    /**
     * @param int $amount
     * @param bool $withShipping
     *
     * @return $this
     */
    public function normalizeByQty($amount, $withShipping = false)
    {
        $realAmount = $this->getAmount($withShipping);
        if ($withShipping === false) {
            $amount = $amount - $this->getSippingAmount();
        }
        if ($amount != $realAmount) {
            $qty                = $this->getQty();
            $adjustment         = $amount - $realAmount;
            $coef               = $adjustment / $qty;
            $realAmount         = 0;
            $indexForAdjustment = 0;
            $maxSubTotal        = 0;

            foreach ($this->Lines as $index => $line) {
                if ($line->isShipping() === true && $withShipping === false) {
                    continue;
                }
                $subTotal    = $line->getSubTotal();
                $lineQty     = $line->getQty();
                $newSubTotal = $subTotal + $lineQty * $coef;
                $newSubTotal = round($newSubTotal, 0, PHP_ROUND_HALF_DOWN);
                if ($newSubTotal <= 0) {
                    $realAmount = $realAmount + $subTotal;
                    continue;
                }
                $line->setSubTotal($newSubTotal);
                $realAmount = $realAmount + $newSubTotal;
                if ($line->getSubTotal() > $maxSubTotal) {
                    $maxSubTotal        = $line->getSubTotal();
                    $indexForAdjustment = $index;
                }
            }

            $diff = $amount - $realAmount;

            if ($diff != 0) {
                $line        = $this->Lines[$indexForAdjustment];
                $subTotal    = $line->getSubTotal();
                $newSubTotal = $subTotal + $diff;
                $line->setSubTotal($newSubTotal);
            }
        }

        return $this;
    }


    /**
     * @param int $amount
     * @param bool $withShipping
     *
     * @return $this
     */
    public function normalizeBySubTotal($amount, $withShipping = false)
    {
        $realAmount = $this->getAmount($withShipping);
        if ($withShipping === false) {
            $amount = $amount - $this->getSippingAmount();
        }
        if ($amount != $realAmount) {
            $adjustment         = $amount - $realAmount;
            $coef               = $adjustment / $realAmount;
            $realAmount         = 0;
            $indexForAdjustment = 0;
            $maxSubTotal        = 0;

            foreach ($this->Lines as $index => $line) {
                if ($line->isShipping() === true && $withShipping === false) {
                    continue;
                }
                $subTotal    = $line->getSubTotal();
                $newSubTotal = $subTotal + $subTotal * $coef;
                $newSubTotal = round($newSubTotal, 0, PHP_ROUND_HALF_DOWN);
                if ($newSubTotal <= 0) {
                    $realAmount = $realAmount + $subTotal;
                    continue;
                }
                $line->setSubTotal($newSubTotal);
                $realAmount = $realAmount + $newSubTotal;
                if ($line->getSubTotal() > $maxSubTotal) {
                    $maxSubTotal        = $line->getSubTotal();
                    $indexForAdjustment = $index;
                }
            }

            $diff = $amount - $realAmount;

            if (abs($diff) >= 1) {
                $line        = $this->Lines[$indexForAdjustment];
                $subTotal    = $line->getSubTotal();
                $newSubTotal = $subTotal + $diff;
                $line->setSubTotal($newSubTotal);
            }
        }

        return $this;
    }
}