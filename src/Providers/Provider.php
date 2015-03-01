<?php

namespace nickurt\PostcodeApi\Providers;

use \GuzzleHttp\Client as Client;
use \nickurt\PostcodeApi\Exception\MalformedURLException;

abstract class Provider implements ProviderInterface
{
    protected $apiKey;
    protected $requestUrl;

    protected $httpClient;

    public function __construct()
    {
        $this->setHttpClient(new Client());
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
     * @return mixed
     */
    public function getHttpClient()
    {
        return $this->httpClient;
    }

    /**
     * @param $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @param $url
     * @throws MalformedURLException
     */
    public function setRequestUrl($url)
    {
        if( filter_var($url, FILTER_VALIDATE_URL) === false ) {
            throw new MalformedURLException();
        }

        $this->requestUrl = $url;
    }

    /**
     * @return mixed
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @return mixed
     */
    public function getRequestUrl()
    {
        return $this->requestUrl;
    }

    /**
     * @return mixed
     */
    protected abstract function request();

    /**
     * @param $postCode
     * @return mixed
     */
    protected abstract function find($postCode);

    /**
     * @param $postCode
     * @return mixed
     */
    protected abstract function findByPostcode($postCode);

    /**
     * @param $postCode
     * @param $houseNumber
     * @return mixed
     */
    protected abstract function findByPostcodeAndHouseNumber($postCode, $houseNumber);
}