<?php

namespace nickurt\PostcodeApi\tests;

use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        config()->set('postcodeapi', [
            'Fake' => [
                'code' => 'nl_NL'
            ],
            'NationaalGeoRegister' => [
                'url' => 'http://geodata.nationaalgeoregister.nl/locatieserver/v3/free',
                'key' => 'key',
                'secret' => 'secret',
                'options' => [
                    'foo' => 'bar'
                ],
                'code' => 'nl_NL'
            ],
            'PostcodeApiNuV3Sandbox' => [
                'alias' => \nickurt\PostcodeApi\Providers\nl_NL\PostcodeApiNuV3::class,
                'url' => 'https://sandbox.postcodeapi.nu/v3/lookup/%s/%s',
                'key' => 'key',
                'code' => 'nl_NL'
            ],
        ]);
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'PostcodeApi' => \nickurt\PostcodeApi\Facade::class
        ];
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            \nickurt\PostcodeApi\ServiceProvider::class
        ];
    }
}
