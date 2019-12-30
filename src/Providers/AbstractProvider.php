<?php

namespace nickurt\PostcodeApi\Providers;

abstract class AbstractProvider implements ProviderInterface
{
    /** @var string */
    protected $apiKey;

    /** @var string */
    protected $apiSecret;

    /** @var \GuzzleHttp\Client */
    protected $client;

    /** @var array */
    protected $options = [];

    /** @var string */
    protected $requestUrl;

    /**
     * @param $uri
     * @param array $options
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function get($uri, array $options = [])
    {
        try {
            $response = $this->getHttpClient()->get($uri, $options);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return json_decode($e->getResponse()->getBody(), true);
        }

        return json_decode($response->getBody(), true);
    }

    /**
     * @return \GuzzleHttp\Client
     */
    public function getHttpClient()
    {
        return $this->client ?? $this->client = new \GuzzleHttp\Client();
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
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
     * @param string $apiSecret
     * @return $this
     */
    public function setApiSecret($apiSecret)
    {
        $this->apiSecret = $apiSecret;

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
     * @param array $options
     * @return $this
     */
    public function setOptions(array $options)
    {
        $this->options = array_merge($this->getOptions(), $options);

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
     * @param $uri
     * @param array $options
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function post($uri, array $options = [])
    {
        try {
            $response = $this->getHttpClient()->post($uri, $options);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return json_decode($e->getResponse()->getBody(), true);
        }

        return json_decode($response->getBody(), true);
    }

    /**
     * @param \GuzzleHttp\ClientInterface $client
     * @return $this
     */
    public function setHttpClient(\GuzzleHttp\ClientInterface $client)
    {
        $this->client = $client;

        return $this;
    }
}
