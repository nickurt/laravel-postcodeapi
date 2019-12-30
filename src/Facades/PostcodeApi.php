<?php

namespace nickurt\PostcodeApi\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method \nickurt\PostcodeApi\Concerns\Provider create(string $provider)
 * @method static extend(string $driver, \Closure $callback)
 *
 * @see \nickurt\PostcodeApi\ProviderManager
 */
class PostcodeApi extends Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'PostcodeApi';
    }
}
