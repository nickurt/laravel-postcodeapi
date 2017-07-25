<?php

namespace nickurt\PostcodeApi\PostcodeApi;

if (! function_exists('postcodeapi')) {
    function postcodeapi(string $provider)
    {
        return app(PostcodeApi::class)->create($provider);
    }
}