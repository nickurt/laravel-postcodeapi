<?php

namespace nickurt\PostcodeApi;

/**
 * @method static create(string $provider)
 * @method static extend(string $driver, \Closure $callback)
 *
 * @see \nickurt\PostcodeApi\ProviderManager
 */
class Facade extends \Illuminate\Support\Facades\Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'PostcodeApi';
    }
}
