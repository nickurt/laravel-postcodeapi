<?php

namespace nickurt\PostcodeApi\tests;

use nickurt\PostcodeApi\ProviderFactory as PostcodeApi;
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
        config()->set('postcodeapi', include(__DIR__ . '/../config/postcodeapi.php'));
    }

    /** @test */
    public function it_can_create_a_new_provider_via_helper_function()
    {
        $this->assertInstanceOf(\nickurt\postcodeapi\Providers\nl_NL\NationaalGeoRegister::class, postcodeapi('NationaalGeoRegister'));
    }

    /** @test */
    public function it_can_work_with_app_instance()
    {
        $this->assertInstanceOf(\nickurt\PostcodeApi\ProviderFactory::class, app('PostcodeApi'));

        $this->assertInstanceOf(\nickurt\PostcodeApi\ProviderFactory::class, $this->app['PostcodeApi']);
    }

    /** @test */
    public function it_can_throw_exception_by_unknown_provider()
    {
        $this->expectException(\nickurt\PostcodeApi\Exception\InvalidArgumentException::class);
        $this->expectExceptionMessage('Unable to use the provider "blablablabla"');

        PostcodeApi::create('blablablabla');
    }

    /** @test */
    public function it_can_work_via_postcodeapi_facade_factory_for_a_known_provider()
    {
        /** @var \nickurt\PostcodeApi\Providers\nl_NL\NationaalGeoRegister $nationaalGeoRegister */
        $nationaalGeoRegister = PostcodeApi::create('NationaalGeoRegister');

        $this->assertInstanceOf(\nickurt\postcodeapi\Providers\Provider::class, $nationaalGeoRegister);
        $this->assertInstanceOf(\nickurt\postcodeapi\Providers\nl_NL\NationaalGeoRegister::class, $nationaalGeoRegister);

        $this->assertSame('http://geodata.nationaalgeoregister.nl/locatieserver/v3/free', $nationaalGeoRegister->getRequestUrl());
    }

    /** @test */
    public function it_can_get_the_http_client()
    {
        $this->assertInstanceOf(\GuzzleHttp\Client::class, PostcodeApi::create('NationaalGeoRegister')->getHttpClient());
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
