<?php

namespace nickurt\PostcodeApi;

class Facade extends \Illuminate\Support\Facades\Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'PostcodeApi';
    }
}
