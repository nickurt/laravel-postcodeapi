<?php

use nickurt\PostcodeApi\ProviderFactory;

if (! function_exists('postcodeapi')) {
    /**
     * @return \nickurt\PostcodeApi\ProviderFactory $provider
     */
    function postcodeapi(string $provider)
    {
        return app(ProviderFactory::class)->create($provider);
    }
}
