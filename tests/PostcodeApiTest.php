<?php

namespace nickurt\PostcodeApi\tests;

use nickurt\PostcodeApi\Facades\PostcodeApi;

class PostcodeApiTest extends TestCase
{
    /** @test */
    public function it_can_create_a_new_provider_via_helper_function()
    {
        $this->assertInstanceOf(\nickurt\PostcodeApi\Providers\Provider::class, postcodeapi('NationaalGeoRegister'));

        $this->assertInstanceOf(\nickurt\PostcodeApi\Providers\nl_NL\NationaalGeoRegister::class, postcodeapi('NationaalGeoRegister')->getAdapter());
    }

    /** @test */
    public function it_can_throw_exception_by_unknown_provider()
    {
        $this->expectException(\nickurt\PostcodeApi\Exceptions\InvalidArgumentException::class);
        $this->expectExceptionMessage('Unable to use the provider "blablablabla"');

        PostcodeApi::create('blablablabla');
    }

    /** @test */
    public function it_can_work_via_postcodeapi_facade_factory_for_a_known_provider()
    {
        $postcodeApi = PostcodeApi::create('NationaalGeoRegister');

        $this->assertInstanceOf(\nickurt\PostcodeApi\Providers\AbstractAdapter::class, $postcodeApi->getAdapter());
        $this->assertInstanceOf(\nickurt\PostcodeApi\Providers\nl_NL\NationaalGeoRegister::class, $postcodeApi->getAdapter());

        $this->assertSame('http://geodata.nationaalgeoregister.nl/locatieserver/v3/free', $postcodeApi->getAdapter()->getRequestUrl());
    }

    /** @test */
    public function it_can_work_via_postcodeapi_facade_factory_with_legacy_config_format_for_a_known_provider()
    {
        $this->app['config']->set('postcodeapi', [
            'NationaalGeoRegister' => [
                'key' => '',
                'code' => 'nl_NL'
            ],
            'PostcodeApiNuV3Sandbox' => [
                'alias' => \nickurt\PostcodeApi\Providers\nl_NL\PostcodeApiNu::class,
                'key' => '',
                'code' => 'nl_NL'
            ]
        ]);

        $nationaalGeoRegister = PostcodeApi::create('NationaalGeoRegister');

        $this->assertInstanceOf(\nickurt\PostcodeApi\Providers\AbstractAdapter::class, $nationaalGeoRegister->getAdapter());
        $this->assertInstanceOf(\nickurt\PostcodeApi\Providers\nl_NL\NationaalGeoRegister::class, $nationaalGeoRegister->getAdapter());
        $this->assertSame('http://geodata.nationaalgeoregister.nl/locatieserver/v3/free', $nationaalGeoRegister->getAdapter()->getRequestUrl());

        $postcodeApiNuV3Sandbox = PostcodeApi::create('PostcodeApiNuV3Sandbox');

        $this->assertInstanceOf(\nickurt\PostcodeApi\Providers\AbstractAdapter::class, $postcodeApiNuV3Sandbox->getAdapter());
        $this->assertInstanceOf(\nickurt\PostcodeApi\Providers\nl_NL\PostcodeApiNu::class, $postcodeApiNuV3Sandbox->getAdapter());
        $this->assertSame('https://api.postcodeapi.nu/v3/lookup', $postcodeApiNuV3Sandbox->getAdapter()->getRequestUrl());

        $this->assertInstanceOf(\nickurt\PostcodeApi\Providers\Provider::class, postcodeapi('PostcodeApiNuV3Sandbox'));
        $this->assertInstanceOf(\nickurt\postcodeapi\Providers\nl_NL\PostcodeApiNu::class, postcodeapi('PostcodeApiNuV3Sandbox')->getAdapter());
    }

    /** @test */
    public function it_can_work_with_app_instance()
    {
        $this->assertInstanceOf(\nickurt\PostcodeApi\ProviderManager::class, app('PostcodeApi'));

        $this->assertInstanceOf(\nickurt\PostcodeApi\ProviderManager::class, $this->app['PostcodeApi']);
    }
}
