<?php

namespace nickurt\PostcodeApi\Tests;

use nickurt\PostcodeApi\ProviderFactory as PostcodeApi;

class PostcodeApiTest extends TestCase
{
    /** @test */
    public function it_can_create_a_new_provider_via_helper_function()
    {
        $this->assertInstanceOf(\nickurt\PostcodeApi\Providers\nl_NL\NationaalGeoRegister::class, postcodeapi('NationaalGeoRegister'));
    }

    /** @test */
    public function it_can_work_with_app_instance()
    {
        $this->assertInstanceOf(PostcodeApi::class, app('PostcodeApi'));

        $this->assertInstanceOf(PostcodeApi::class, $this->app['PostcodeApi']);
    }

    /** @test */
    public function it_can_throw_exception_by_unknown_provider()
    {
        $this->expectException(\nickurt\PostcodeApi\Exception\InvalidArgumentException::class);
        $this->expectExceptionMessage('Unable to use the provider "blablablabla"');

        PostcodeApi::create('blablablabla');
    }

    /** @test */
    public function it_can_throw_exception_by_known_provider_unknown_class()
    {
        $this->expectException(\nickurt\PostcodeApi\Exception\InvalidArgumentException::class);
        $this->expectExceptionMessage('Unable to use the provider "Fake"');

        PostcodeApi::create('Fake');
    }

    /** @test */
    public function it_can_work_via_postcodeapi_facade_factory_for_a_known_provider()
    {
        /** @var \nickurt\PostcodeApi\Providers\nl_NL\NationaalGeoRegister $nationaalGeoRegister */
        $nationaalGeoRegister = PostcodeApi::create('NationaalGeoRegister');

        $this->assertInstanceOf(\nickurt\PostcodeApi\Providers\Provider::class, $nationaalGeoRegister);
        $this->assertInstanceOf(\nickurt\PostcodeApi\Providers\nl_NL\NationaalGeoRegister::class, $nationaalGeoRegister);

        $this->assertSame(['foo' => 'bar'], $nationaalGeoRegister->getOptions());
        $this->assertSame('key', $nationaalGeoRegister->getApiKey());
        $this->assertSame('secret', $nationaalGeoRegister->getApiSecret());
        $this->assertSame('http://geodata.nationaalgeoregister.nl/locatieserver/v3/free', $nationaalGeoRegister->getRequestUrl());
    }

    /** @test */
    public function it_can_get_the_http_client()
    {
        $this->assertInstanceOf(\GuzzleHttp\Client::class, PostcodeApi::create('NationaalGeoRegister')->getHttpClient());
    }

    /** @test */
    public function it_can_create_a_new_provider_with_alias_via_helper_function()
    {
        $this->assertInstanceOf(\nickurt\PostcodeApi\Providers\nl_NL\PostcodeApiNuV3::class, postcodeapi('PostcodeApiNuV3Sandbox'));
    }

}
