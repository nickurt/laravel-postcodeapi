<?php

namespace nickurt\PostcodeApi;

use nickurt\PostcodeApi\Exception\InvalidArgumentException;
use nickurt\PostcodeApi\Providers\Provider;

class ProviderFactory
{
    /**
     * @param string $provider
     * @return Provider $class
     * @throws InvalidArgumentException
     */
    public static function create($provider)
    {
        if (!$config = config()->get('postcodeapi.' . $provider)) {
            throw new InvalidArgumentException(sprintf('Unable to use the provider "%s"', $provider));
        }

        /** @var Provider $class */
        if (class_exists($providerClass = 'nickurt\\PostcodeApi\\Providers\\' . $config['code'] . '\\' . $provider)) {
            $class = (new $providerClass);
            $class->setApiKey($config['key']);
            $class->setRequestUrl($config['url']);

            if (isset($config['secret'])) {
                $class->setApiSecret($config['secret']);
            }

            return $class;
        }

        throw new InvalidArgumentException(sprintf('Unable to use the provider "%s"', $provider));
    }
}
