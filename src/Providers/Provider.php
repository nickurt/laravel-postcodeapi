<?php

namespace nickurt\PostcodeApi\Providers;

use \GuzzleHttp\Client as Client;
use \nickurt\PostcodeApi\Exception\MalformedURLException;

abstract class Provider implements ProviderInterface
{
    /**
     * @var
     */
    protected $apiKey;

    /**
     * @var
     */
    protected $requestUrl;

    /**
     * @var
     */
    protected $httpClient;

    /**
     * Provider constructor.
     */
    public function __construct()
    {
        $this->setHttpClient(new Client());
    }

    /**
     * @return mixed
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param $apiKey
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
     * @return mixed
     */
    public function getHttpClient()
    {
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
     * @return mixed
     */
    public function getRequestUrl()
    {
        return $this->requestUrl;
    }

    /**
     * @param $url
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
     * @param $apiSecret
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
