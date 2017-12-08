<?php

namespace Chekonline\Cashbox;

class ChekonlineRequest
{
	/**
	 * @var string API endpoint for this request.
	 */
	protected $endpoint;

	/**
	 * @var array headers to send with this request.
	 */
	protected $headers = [];

	/**
	 * @var array The parameters to send with this request.
	 */
	protected $params = [];

	/**
	 * @var string cert to send with this request.
	 */
	protected $certPath = '';

	/**
	 * @var string key to send with this request.
	 */
	protected $keyPath = '';

	/**
	 * @var string password to send with this request.
	 */
	protected $certPassword = '';

	/**
	 * @var string api host
	 */
	protected $host = '';

	/**
	 * @var string method for this request.
	 */
	protected $method;

	/**
	 * @var int
	 */
	protected $timeout = 60;

	/**
	 * ChekonlineRequest constructor.
	 * @param $certPath
	 * @param $keyPath
	 * @param $certPassword
	 * @param null $method
	 * @param null $endpoint
	 * @param array $params
	 * @param int $timeout
	 * @param string $host
	 */

	public function __construct(
		$certPath,
		$keyPath,
		$certPassword,
		$method = null,
		$endpoint = null,
		$params = array([]),
		$timeout = 60,
		$host = ''
	)
	{
		$this->setMethod($method);
		$this->setEndpoint($endpoint);
		$this->setParams($params);
		$this->setTimeout($timeout);
		$this->setCertPath($certPath);
		$this->setKeyPath($keyPath);
		$this->setCertPassword($certPassword);
		$this->setHost($host);
	}

	/**
	 * Set the endpoint for this request.
	 *
	 * @param string $endpoint
	 */
	public function setEndpoint($endpoint)
	{
		$this->endpoint = $endpoint;
	}

	/**
	 * Return the API Endpoint for this request.
	 *
	 * @return string
	 */
	public function getEndpoint()
	{
		return $this->endpoint;
	}

	/**
	 * Set the params for this request.
	 *
	 * @param array $params
	 */
	public function setParams($params = [])
	{
		$this->params = array_merge($this->params, $params);
	}

	/**
	 * Return the params for this request.
	 *
	 * @return array
	 */
	public function getParams()
	{
		return $this->params;
	}

	/**
	 * Set the headers for this request.
	 *
	 * @param string $headers
	 */
	public function setHeaders($headers)
	{
		$this->headers[] = $headers;
	}
	/**
	 * Return the headers for this request.
	 *
	 * @return array
	 */
	public function getHeaders()
	{
		return $this->headers;
	}

	/**
	 * @param string $certPath
	 */
	public function setCertPath($certPath)
	{
		$this->certPath = $certPath;
	}

	/**
	 * @param string $keyPath
	 */
	public function setKeyPath($keyPath)
	{
		$this->keyPath = $keyPath;
	}

	/**
	 * @param string $certPassword
	 */
	public function setCertPassword($certPassword)
	{
		$this->certPassword = $certPassword;
	}

	/**
	 * @param int $timeout
	 */
	public function setTimeout($timeout)
	{
		$this->timeout = $timeout;
	}

	/**
	 * @param string $host
	 */
	public function setHost($host)
	{
		$this->host = $host;
	}

	/**
	 * @return string
	 */
	public function getHost()
	{
		return $this->host;
	}

	/**
	 * @return string
	 */
	public function getMethod()
	{
		return $this->method;
	}

	/**
	 * @param string $method
	 */
	public function setMethod($method)
	{
		$this->method = $method;
	}

	/**
	 * @return string
	 */
	public function getCertPath()
	{
		return $this->certPath;
	}

	/**
	 * @return string
	 */
	public function getKeyPath()
	{
		return $this->keyPath;
	}

	/**
	 * @return string
	 */
	public function getCertPassword()
	{
		return $this->certPassword;
	}

	/**
	 * @return int
	 */
	public function getTimeout()
	{
		return $this->timeout;
	}

    /**
     * @return string
     */
    public function __toString()
    {
        $properties = '';
        $objVars =  get_object_vars($this);
        foreach ($objVars as $key => $value) {
            if ($value) {
                $properties .= $this->getStingOfProperty($key, $value);
            }
        }
        return $properties;
    }

    /**
     * @param string $key
     * @param string|array $value
     * @return string
     */
    private function getStingOfProperty($key, $value)
    {
        $properties = '';
        if (is_array($value)) {
            $properties .= "{$key} :\n";
            /** @var string $lKey */
            foreach ($value as $lKey => $lValue) {
                $properties .= "\t" . $this->getStingOfProperty($lKey, $lValue);
            }
            return $properties;
        } else {
            return "{$key} : {$value}\n";
        }
    }
}