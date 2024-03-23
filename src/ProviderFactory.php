<?php

namespace nickurt\PostcodeApi;

use nickurt\PostcodeApi\Exception\InvalidArgumentException;
use nickurt\PostcodeApi\Providers\Provider;

class ProviderFactory
{
    /**
     * @param  string  $provider
     * @return Provider $class
     *
     * @throws InvalidArgumentException
     */
    public static function create($provider)
    {
        if (! $config = config()->get('postcodeapi.'.$provider)) {
            throw new InvalidArgumentException(sprintf('Unable to use the provider "%s"', $provider));
        }

        /** @var Provider $providerClass */
        $providerClass = isset($config['alias']) && class_exists($config['alias'])
            ? $config['alias']
            : "nickurt\\PostcodeApi\\Providers\\{$config['code']}\\{$provider}";

        if (! class_exists($providerClass)) {
            throw new InvalidArgumentException(sprintf('Unable to use the provider "%s"', $provider));
        }

        $class = (new $providerClass);
        $class->setApiKey($config['key']);
        $class->setRequestUrl($config['url']);

        if (isset($config['secret'])) {
            $class->setApiSecret($config['secret']);
        }

        if (isset($config['options'])) {
            $class->setOptions($config['options']);
        }

        return $class;
    }
}
