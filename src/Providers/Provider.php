<?php

namespace nickurt\PostcodeApi\Providers;

use \GuzzleHttp\Client as Client;
use \nickurt\PostcodeApi\Exception\MalformedURLException;

abstract class Provider implements ProviderInterface
{
    /** @var string */
    protected $apiKey;

    /** @var string */
    protected $requestUrl;

    /** @var \GuzzleHttp\Client */
    protected $httpClient;

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param string $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @return mixed
     */
    public function getApiSecret()
    {
        return $this->apiSecret;
    }

    /**
     * @return Client
     */
    public function getHttpClient()
    {
        if (!isset($this->httpClient)) {
            $this->httpClient = new \GuzzleHttp\Client();

            return $this->httpClient;
        }

        return $this->httpClient;
    }

    /**
     * @param Client $client
     * @return $this
     */
    public function setHttpClient(Client $client)
    {
        $this->httpClient = $client;

        return $this;
    }

    /**
     * @return string
     */
    public function getRequestUrl()
    {
        return $this->requestUrl;
    }

    /**
     * @param string $url
     * @throws MalformedURLException
     */
    public function setRequestUrl($url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new MalformedURLException();
        }

        $this->requestUrl = $url;
    }

    /**
     * @param string $apiSecret
     */
    public function setApiSecret($apiSecret)
    {
        $this->apiSecret = $apiSecret;
    }

    /**
     * @return mixed
     */
    abstract protected function request();

    /**
     * @param $postCode
     * @return mixed
     */
    abstract protected function find($postCode);

    /**
     * @param $postCode
     * @return mixed
     */
    abstract protected function findByPostcode($postCode);

    /**
     * @param $postCode
     * @param $houseNumber
     * @return mixed
     */
    abstract protected function findByPostcodeAndHouseNumber($postCode, $houseNumber);
}
