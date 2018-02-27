<?php

namespace Chekonline\Cashbox;

use Chekonline\Cashbox\Exceptions\ChekonlineSDKException;

class Api
{
	/**
	 * @var string|null host to send with this request.
	 */
	protected $host;

	/**
	 * @var int Timeout of the request in seconds.
	 */
	protected $timeout = 60;

	/**
	 * @var string|null cert to send with this request.
	 */
	protected $certPath;

	/**
	 * @var string|null key to send with this request.
	 */
	protected $keyPath;

	/**
	 * @var string password to send with this request.
	 */
	protected $certPassword = '';

	/**
	 * @var string CMS name
	 */
	protected $clientName = '';

	/**
	 * @var string CMS version
	 */
	protected $clientVer = '';

	/**
	 * @var ChekonlineClient|null http client
	 */
	protected $client;

    /**
     * @var array
     */
	protected $params = array();

	/**
	 * Api constructor.
	 * @param string $host
	 * @param \Chekonline\Cashbox\HttpClients\HttpClientInterface|null $httpClientHandler
	 */
	public function __construct(
		$host,
		$httpClientHandler = null
	)
	{
		$this->host = trim($host);
		$this->client =  new ChekonlineClient($httpClientHandler);
	}

    /**
     * Api destructor
     */
    public function __destruct ()
    {
        @unlink($this->certPath);
        @unlink($this->keyPath);
    }

    /**
	 * @param string $cert
	 * @param string $key
	 * @param string $certPassword
	 */
	public function setCertificate($cert, $key, $certPassword = '')
	{
        $certPassword = $certPassword == null? $certPassword: '';

		if (file_exists($cert)) {
			$this->certPath = $cert;
		} else {
            if (empty($cert) == false) {
                $tempFileName = tempnam(sys_get_temp_dir(), 'php');
                $tempFile     = fopen($tempFileName, 'r+');
                fwrite($tempFile, $cert);
                $this->certPath = $tempFileName;
            }
		}
		if (file_exists($key)) {
			$this->keyPath = $key;
		} else {
            if (empty($key) == false) {
                $tempFileName = tempnam(sys_get_temp_dir(), 'php');
                $tempFile     = fopen($tempFileName, 'r+');
                fwrite($tempFile, $key);
                $this->keyPath = $tempFileName;
            }
		}
		$this->certPassword = $certPassword;
	}

	/**
	 * @param $method
	 * @param $endpoint
	 * @param array $params
	 * @return ChekonlineResponse
	 */
	public function sendRequest(
		$method,
		$endpoint,
		$params = array([])
	)
	{
		$request = $this->request($method, $endpoint, $params);

		return $this->client->sendRequest($request);
	}

	/**
	 * @param $method
	 * @param $endpoint
	 * @param array $param
	 * @return ChekonlineRequest
	 */
	public function request(
		$method,
		$endpoint,
		$param = array([])
	)
	{
		$request = new ChekonlineRequest(
			$this->certPath,
			$this->keyPath,
			$this->certPassword,
			$method,
			$endpoint,
			$param,
			$this->timeout,
			$this->host
		);

		$request->setHeaders("Content-Type: application/json");
		if ($this->clientName) {
			$request->setHeaders("XComepayPointID: {$this->clientName} {$this->clientVer}");
		}

		return $request;
	}


	/**
	 * @param \Chekonline\Cashbox\Commands\CommandInterface $command
	 * @return ChekonlineResponse|null
     */
	public function executeCommand($command)
	{
		$data = json_encode($command->getParams());
        if (!empty($command::NAME)) {
            $requestParam = array_merge($this->params, array('body' => $data));
            return $this->sendRequest('POST', $command::NAME, $requestParam);
        }
        return null;
	}

	/**
	 * @param string $clientName
	 */
	public function setClientName($clientName)
	{
		$this->clientName = $clientName;
	}

	/**
	 * @param string $clientVer
	 */
	public function setClientVer($clientVer)
	{
		$this->clientVer = $clientVer;
	}

    /**
     * @param $proxy
     * @return Api
     */
    public function setProxy ($proxy)
    {
        $this->params['proxy'] = $proxy;
        return $this;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @throws ChekonlineSDKException
     */
    public function validate()
    {
        if (filter_var($this->host, FILTER_VALIDATE_URL) == false) {
            throw new ChekonlineSDKException("Invalid host {$this->host}");
        }
    }
}