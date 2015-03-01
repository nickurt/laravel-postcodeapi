<?php

namespace nickurt\PostcodeApi;

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
