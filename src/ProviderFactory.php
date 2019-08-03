<?php

namespace nickurt\PostcodeApi;

class ProviderFactory
{
    /**
     * @param $provider
     * @return mixed
     */
    public static function create($provider)
    {
        if (!$config = config()->get('postcodeapi.' . $provider)) {
            throw new \InvalidArgumentException(sprintf('Unable to use the provider "%s"', $provider));
        }

        $providerClass = 'nickurt\\PostcodeApi\\Providers\\' . $config['code'] . '\\' . $provider;

        if (class_exists($providerClass)) {
            $class = (new $providerClass);
            $class->setApiKey($config['key']);
            $class->setRequestUrl($config['url']);

            if (isset($config['secret'])) {
                $class->setApiSecret($config['secret']);
            }

            return $class;
        }

        throw new \InvalidArgumentException(sprintf('Unable to use the provider "%s"', $provider));
    }
}
