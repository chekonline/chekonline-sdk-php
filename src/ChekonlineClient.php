<?php

namespace Chekonline\Cashbox;

use Chekonline\Cashbox\HttpClients\CurlHttpClient;

class ChekonlineClient
{
    /**
     * @const string chekonline API path
     */
    const API_PATH = '/fr/api/v2/';

    /**
     * @var \Chekonline\Cashbox\HttpClients\HttpClientInterface|null HTTP Client
     */
    protected $httpClientHandler;

    /**
     * Inital a new ChekonlineClient object
     *
     * @param \Chekonline\Cashbox\HttpClients\HttpClientInterface|null $httpClientHandler
     */
    function __construct($httpClientHandler = null)
    {
        $this->httpClientHandler = $httpClientHandler ?: new CurlHttpClient();
    }

    /**
     * Returns the HTTP client handler.
     *
     * @return \Chekonline\Cashbox\HttpClients\HttpClientInterface
     */
    public function getHttpClientHandler()
    {
        return $this->httpClientHandler;
    }

    /**
     * @return string
     */
    public function getApiPath()
    {
        return static::API_PATH;
    }

    /**
     * @param ChekonlineRequest $request
     *
     * @return ChekonlineResponse
     */
    public function sendRequest($request)
    {
        $rawResponse = $this->httpClientHandler->send(
            $request->getCertPath(),
            $request->getKeyPath(),
            $request->getCertPassword(),
            $request->getHost() . $this->getApiPath() . $request->getEndpoint(),
            $request->getMethod(),
            $request->getHeaders(),
            $request->getParams(),
            $request->getTimeout()
        );
        $response    = new ChekonlineResponse($request, $rawResponse);

        return $response;
    }

}