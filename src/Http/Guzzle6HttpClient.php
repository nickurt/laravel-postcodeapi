<?php

namespace nickurt\PostcodeApi\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;

class Guzzle6HttpClient implements HttpClientInterface
{
    /** @var Client */
    protected $client;

    /**
     * @param Client|null $client
     */
    public function __construct(Client $client = null)
    {
        $this->client = $client ?: new Client();
    }

    /**
     * @param string $uri
     * @param array $options
     * @return ResponseInterface
     */
    public function get($uri, array $options = [])
    {
        try {
            $response = $this->getHttpClient()->get($uri, $options);
        } catch (RequestException $e) {
            return $e->getResponse();
        }

        return $response;
    }

    /**
     * @return Client
     */
    public function getHttpClient()
    {
        return $this->client;
    }

    /**
     * @param string $uri
     * @param array $options
     * @return ResponseInterface
     */
    public function post($uri, array $options = [])
    {
        try {
            $response = $this->getHttpClient()->post($uri, $options);
        } catch (RequestException $e) {
            return $e->getResponse();
        }

        return $response;
    }

    /**
     * @param Client $client
     * @return $this
     */
    public function setHttpClient(Client $client)
    {
        $this->client = $client;

        return $this;
    }
}
