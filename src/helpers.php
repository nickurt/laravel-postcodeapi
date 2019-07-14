<?php

use nickurt\PostcodeApi\ProviderFactory;

if (!function_exists('postcodeapi')) {
    function postcodeapi(string $provider)
    {
        return app(ProviderFactory::class)->create($provider);
    }
}