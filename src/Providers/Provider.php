<?php

namespace nickurt\PostcodeApi\Providers;

use GuzzleHttp\Client as Client;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Exception\MalformedURLException;

abstract class Provider implements ProviderInterface
{
    protected ?string $apiKey = null;

    protected ?string $apiSecret = null;

    protected string $requestUrl = '';

    protected array $options = [];

    protected Client $httpClient;

    public function getApiKey(): ?string
    {
        return $this->apiKey;
    }

    public function setOptions(array $options): Provider
    {
        $this->options = array_merge($this->getOptions(), $options);

        return $this;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function setApiKey(string $apiKey): Provider
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    public function getApiSecret(): ?string
    {
        return $this->apiSecret;
    }

    public function getRequestUrl(): string
    {
        return $this->requestUrl;
    }

    public function setRequestUrl($url): Provider
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new MalformedURLException($url);
        }

        $this->requestUrl = $url;

        return $this;
    }

    public function setApiSecret(string $apiSecret): Provider
    {
        $this->apiSecret = $apiSecret;

        return $this;
    }

    abstract public function find(string $postCode): Address;

    abstract public function findByPostcode(string $postCode): Address;

    abstract public function findByPostcodeAndHouseNumber(string $postCode, string $houseNumber): Address;

    /**
     * @return mixed
     */
    abstract protected function request();
}
