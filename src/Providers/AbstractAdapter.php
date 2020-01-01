<?php

namespace nickurt\PostcodeApi\Providers;

use nickurt\PostcodeApi\Concerns\Adapter;

abstract class AbstractAdapter implements Adapter
{
    /** @var array */
    protected $options = [];

    /** @var string */
    protected $requestUrl;

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
}
