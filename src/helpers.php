<?php

use nickurt\PostcodeApi\ProviderManager;

if (!function_exists('postcodeapi')) {
    /**
     * @param string $provider
     * @return \nickurt\PostcodeApi\Providers\Provider $provider
     */
    function postcodeapi(string $provider)
    {
        return app(ProviderManager::class)->create($provider);
    }
}
