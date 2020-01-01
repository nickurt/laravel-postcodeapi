<?php

namespace nickurt\PostcodeApi\Http;

use Psr\Http\Message\ResponseInterface;

interface HttpClientInterface
{
    /**
     * @param string $uri
     * @param array $options
     * @return ResponseInterface
     */
    public function get($uri, array $options = []);

    /**
     * @param string $uri
     * @param array $options
     * @return ResponseInterface
     */
    public function post($uri, array $options = []);
}
