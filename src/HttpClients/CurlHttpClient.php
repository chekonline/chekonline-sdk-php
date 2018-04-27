<?php

namespace Chekonline\Cashbox\HttpClients;

class CurlHttpClient implements HttpClientInterface
{
    /**
     * Timeout of the request in seconds.
     *
     * @var int
     */
    protected $timeOut = 30;

    /**
     * {@inheritdoc}
     */
    public function send(
        $certPath,
        $keyPath,
        $certPassword,
        $url,
        $method,
        $headers = array([]),
        $options = array([]),
        $timeOut = 30
    ) {
        $this->timeOut = $timeOut;

        $body  = isset($options['body']) ? $options['body'] : null;
        $proxy = isset($options['proxy']) ? $options['proxy'] : null;

        $options = $this->getOptions(
            $url,
            $certPath,
            $keyPath,
            $certPassword,
            $headers,
            $body,
            $proxy
        );
        $ch      = curl_init();
        curl_setopt_array($ch, $options);

        $response = curl_exec($ch);

        $curlError = 0;
        if (curl_errno($ch)) {
            $curlError     = curl_error($ch);
            $responseArray = array('httpError' => $curlError);
        } else {
            $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $header_size    = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $headers        = substr($response, 0, $header_size);
            $body           = substr($response, $header_size);
            $responseArray  = array(
                'headers'        => $headers,
                'body'           => $body,
                'httpStatusCode' => $httpStatusCode,
                'httpError'      => $curlError
            );
        }

        curl_close($ch);

        return $responseArray;
    }

    /**
     * @param $url
     * @param $certPath
     * @param $keyPath
     * @param $certPassword
     * @param $headers
     * @param $body
     * @param $proxy
     *
     * @return array
     */
    private function getOptions(
        $url,
        $certPath,
        $keyPath,
        $certPassword,
        $headers,
        $body,
        $proxy
    ) {
        $options = array(
            CURLOPT_URL            => $url,
            CURLOPT_CONNECTTIMEOUT => $this->timeOut,
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_POSTFIELDS     => $body,
            CURLOPT_HEADER         => true,
            CURLOPT_POST           => true,
            CURLOPT_RETURNTRANSFER => true,
        );
        if ($certPath) {
            $options[CURLOPT_SSLCERT]       = $certPath;
            $options[CURLOPT_SSLKEY]        = $keyPath;
            $options[CURLOPT_SSLCERTPASSWD] = $certPassword;
        }

        if (isset($proxy)) {
            $options[CURLOPT_PROXY] = $proxy;
        }

        return $options;
    }
}