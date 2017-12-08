<?php

namespace Chekonline\Cashbox;

class ChekonlineResponse
{
    /**
     * @var \Chekonline\Cashbox\ChekonlineRequest
     */
    protected $request;

	/**
	 * @var int
	 */
	protected $httpStatusCode;

	/**
	 * @var string
	 */
	protected $httpError;

	/**
	 * @var array
	 */
	protected $headers;

	/**
	 * @var array
	 */
	protected $body;

	/**
	 * @var string
	 */
	protected $endpoint;

	/**
	 * @var int
	 */
	protected $apiErrorCode = 0;

	/**
	 * @var string
	 */
	protected $apiErrorMessage = '';

	/**
	 * @var \Chekonline\Cashbox\Exceptions\ChekonlineSDKException
	 */
	protected $thrownException;

	/**
	 * ChekonlineResponse constructor.
	 * @param ChekonlineRequest $request
	 * @param array $result
	 */
	public function __construct($request, $result)
	{
	    $this->request = $request;
		if ($result['httpError']) {
			$this->setHttpError($result['httpError']);
		} else {
			$this->setHeaders($result['headers']);
			$this->setBody($result['body']);
			$this->setHttpStatusCode($result['httpStatusCode']);
			if (isset($this->body['Response'])) {
				if ($this->body['Response']['Error']) {
					$this->setApiErrorCode($this->body['Response']['Error']);
					if (isset($this->body['Response']['ErrorMessages'])) {
                        $this->setApiErrorMessage($this->body['Response']['ErrorMessages']);
                    }
				}
			} elseif (isset($this->body['Responses'])){
				if ($this->body['Error']) {
					$this->setApiErrorCode($this->body['Response']['Error']);
				}
			} elseif (isset($this->body['FCEError'])) {
				$this->setApiErrorCode($this->body['FCEError']);
				if (isset($this->body['ErrorDescription'])) {
                    $this->setApiErrorMessage(array($this->body['ErrorDescription']));
                }
			}
		}
		$this->setEndpoint($this->request->getEndpoint());
	}

	/**
	 * @return array
	 */
	public function getHeaders()
	{
		return $this->headers;
	}

	/**
	 * @param string $headers
	 */
	public function setHeaders($headers)
	{
		$headers = explode("\r\n", $headers);
        $headersArray = array();
		foreach ($headers as $header) {
			if (!strpos($header, ":")) continue;

			$header = explode(': ', $header);
			$headersArray[$header[0]] = $header[1];
		}
		$this->headers = $headersArray;
	}

	/**
	 * @return array
	 */
	public function getBody()
	{
		return $this->body;
	}

	/**
	 * @param $bodyRaw
	 */
	public function setBody($bodyRaw)
	{
		$this->body = json_decode($bodyRaw, true);
	}

	/**
	 * @return string
	 */
	public function getEndpoint()
	{
		return $this->endpoint;
	}

	/**
	 * @param string $endpoint
	 */
	public function setEndpoint($endpoint)
	{
		$this->endpoint = $endpoint;
	}

	/**
	 * @return int
	 */
	public function getHttpStatusCode()
	{
		return $this->httpStatusCode;
	}

	/**
	 * @param int $httpStatusCode
	 */
	public function setHttpStatusCode($httpStatusCode)
	{
		$this->httpStatusCode = $httpStatusCode;
	}


	/**
	 * @return int
	 */
	public function getApiErrorCode()
	{
		return $this->apiErrorCode;
	}

	/**
	 * @param int $apiErrorCode
	 */
	public function setApiErrorCode($apiErrorCode)
	{
		$this->apiErrorCode = $apiErrorCode;
	}

	/**
	 * @return string
	 */
	public function getApiErrorMessage()
	{
		return $this->apiErrorMessage;
	}

	/**
	 * @param array $apiErrorMessages
	 */
	public function setApiErrorMessage($apiErrorMessages)
	{
		$this->apiErrorMessage = join(', ', $apiErrorMessages);
	}

	/**
	 * @return string
	 */
	public function getHttpError()
	{
		return $this->httpError;
	}

	/**
	 * @param string $httpError
	 */
	public function setHttpError($httpError)
	{
		$this->httpError = $httpError;
	}

    /**
     * @param mixed $request
     * @return ChekonlineResponse
     */
    public function setRequest($request)
    {
        $this->request = $request;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRequest()
    {
        return $this->request;
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
     * @param $key
     * @param $value
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
        } elseif($key != 'request')  {
            return "{$key} : {$value}\n";
        }
    }
}