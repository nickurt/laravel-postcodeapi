<?php

namespace nickurt\PostcodeApi\Providers;

use GuzzleHttp\Client as Client;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Exception\MalformedURLException;

abstract class Provider implements ProviderInterface
{
    /** @var string */
    protected $apiKey;

    /** @var string */
    protected $apiSecret;

    /** @var string */
    protected $requestUrl;

    /** @var array */
    protected $options = [];

    /** @var Client */
    protected $httpClient;

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param array $options
     * @return $this
     */
    public function setOptions(array $options)
    {
        $this->options = array_merge($this->getOptions(), $options);

        return $this;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param $apiKey
     * @return $this
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * @return string
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
            $this->httpClient = new Client();

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
     * @return $this
     * @throws MalformedURLException
     */
    public function setRequestUrl($url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new MalformedURLException();
        }

        $this->requestUrl = $url;

        return $this;
    }

    /**
     * @param string $apiSecret
     * @return $this
     */
    public function setApiSecret($apiSecret)
    {
        $this->apiSecret = $apiSecret;

        return $this;
    }

    /**
     * @return mixed
     */
    abstract protected function request();

    /**
     * @param string $postCode
     * @return Address
     */
    abstract protected function find($postCode);

    /**
     * @param string $postCode
     * @return Address
     */
    abstract protected function findByPostcode($postCode);

    /**
     * @param string $postCode
     * @param string $houseNumber
     * @return Address
     */
    abstract protected function findByPostcodeAndHouseNumber($postCode, $houseNumber);
}
