<?php

namespace nickurt\PostcodeApi\tests;

use nickurt\PostcodeApi\Facades\PostcodeApi;

class PostcodeApiTest extends TestCase
{
    /** @test */
    public function it_can_create_a_new_provider_via_helper_function()
    {
        $this->assertInstanceOf(\nickurt\postcodeapi\Providers\nl_NL\NationaalGeoRegister::class, postcodeapi('NationaalGeoRegister'));
    }

    /** @test */
    public function it_can_work_with_app_instance()
    {
        $this->assertInstanceOf(\nickurt\PostcodeApi\ProviderManager::class, app('PostcodeApi'));

        $this->assertInstanceOf(\nickurt\PostcodeApi\ProviderManager::class, $this->app['PostcodeApi']);
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
        /** @var \nickurt\PostcodeApi\Providers\nl_NL\NationaalGeoRegister $nationaalGeoRegister */
        $nationaalGeoRegister = PostcodeApi::create('NationaalGeoRegister');

        $this->assertInstanceOf(\nickurt\postcodeapi\Providers\AbstractProvider::class, $nationaalGeoRegister);
        $this->assertInstanceOf(\nickurt\postcodeapi\Providers\nl_NL\NationaalGeoRegister::class, $nationaalGeoRegister);

        $this->assertSame('http://geodata.nationaalgeoregister.nl/locatieserver/v3/free', $nationaalGeoRegister->getRequestUrl());
    }

    /** @test */
    public function it_can_get_the_http_client()
    {
        $this->assertInstanceOf(\GuzzleHttp\Client::class, PostcodeApi::create('NationaalGeoRegister')->getHttpClient());
    }
}
