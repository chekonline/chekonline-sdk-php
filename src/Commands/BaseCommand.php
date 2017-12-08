<?php

namespace Chekonline\Cashbox\Commands;

use Chekonline\Cashbox\Exceptions\ChekonlineCommandException;

class BaseCommand implements CommandInterface
{
	/**
	 * @var string
	 */
	protected $RequestId;

	/**
	 * @var string
	 */
	protected $ClientId;

	/**
	 * BaseCommand constructor.
	 * @param $requestId
	 */
	public function __construct($requestId)
	{
		$this->setRequestId($requestId);
	}

	/**
	 * @return array
	 */
	public function getParams()
	{
		return get_object_vars($this);
	}

	/**
	 * @return mixed
	 */
	public function getRequestId()
	{
		return $this->RequestId;
	}

	/**
	 * @param mixed $requestId
     * @return $this
	 */
	public function setRequestId($requestId)
	{
		$this->RequestId = $requestId;
        return $this;
	}

	/**
	 * @return mixed
	 */
	public function getClientId()
	{
		return $this->ClientId;
	}

	/**
	 * @param mixed $clientId
     * @return $this
	 */
	public function setClientId($clientId)
	{
		$this->ClientId = $clientId;
		return $this;
	}

    /**
     * @throws \Chekonline\Cashbox\Exceptions\ChekonlineCommandException
     */
    public function validate()
    {
        if (isset($this->RequestId) == false) {
            throw new ChekonlineCommandException('The RequestId must be determined', $this);
        }

    }
}