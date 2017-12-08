<?php

namespace Chekonline\Cashbox\Commands;

use Chekonline\Cashbox\Exceptions\ChekonlineCommandException;

class BatchCommand extends BaseCommand
{
	/**
	 * @const string command name
	 */
	const NAME = 'Batch';

	/**
	 * @const string chekonline API path
	 */
	const API_PATH = '/fr/api/v2/';

	/**
	 * @var array
	 */
	private $Requests = array();

	/**
	 * {@inheritdoc}
	 */
	public function __construct($requestId)
	{
		parent::__construct($requestId);
	}

	/**
	 * @var int
	 */
	private $QueueLen = 100;

	/**
	 * @var string
	 */
	private $Device = 'auto';

	/**
	 * {@inheritdoc}
	 */
	public function getParams()
	{
		$baseParams = parent::getParams();
		$params = array_merge(get_object_vars($this), $baseParams);

		/** @var BaseCommand $request */
		$commands = array();
		foreach ($this->Requests as $request) {
			$commandParams = $request->getParams();
			$commands[] = array('Path' => $this::API_PATH . $request::NAME, 'Request' =>  $commandParams);
		}
		$params['Requests'] = $commands;
		return $params;
	}

	/**
	 * @param \Chekonline\Cashbox\Commands\BaseCommand $command
	 * @return BatchCommand
	 */
	public function addCommandForExecute($command)
	{
		$this->Requests[] = $command;
	}

	/**
	 * @return array
	 */
	public function getCommands()
	{
		return $this->Requests;
	}

	/**
	 * @param int $QueueLen
	 * @return BatchCommand
	 */
	public function setQueueLen($QueueLen)
	{
		$this->QueueLen = $QueueLen;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getQueueLen()
	{
		return $this->QueueLen;
	}

	/**
	 * @param string $Device
	 * @return BatchCommand
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
     * {@inheritdoc}
     */
    public function validate()
    {
        parent::validate();
        if (empty($this->Requests) == true) {
            throw new ChekonlineCommandException('The list of commands for execution is empty');
        }
    }
}