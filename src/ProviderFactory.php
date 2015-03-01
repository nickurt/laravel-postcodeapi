<?php

namespace nickurt\PostcodeApi;

use \Config;

class ProviderFactory {

    /**
     * @param $provider
     * @return mixed
     */
    public static function create($provider)
    {
        if( !isset(Config::get('postcodeapi')[$provider]) )
        {
            throw new \InvalidArgumentException(sprintf('Unable to use the provider "%s"', $provider));
        }

        $configInformation = \Config::get('postcodeapi')[$provider];

        $providerClass = 'nickurt\\PostcodeApi\\Providers\\'.$configInformation['code'].'\\'.$provider;

        if(class_exists($providerClass)) {
            $class = new $providerClass;
            $class->setApiKey($configInformation['key']);
            $class->setRequestUrl($configInformation['url']);

            return $class;
        }

        throw new \InvalidArgumentException(sprintf('Unable to use the provider "%s"', $provider));
    }
}