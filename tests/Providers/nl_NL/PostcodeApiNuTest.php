<?php

namespace nickurt\PostcodeApi\tests\Providers\nl_NL;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Exception\NotSupportedException;
use nickurt\PostcodeApi\Providers\nl_NL\PostcodeApiNu;
use nickurt\PostcodeApi\tests\Providers\BaseProviderTest;

class PostcodeApiNuTest extends BaseProviderTest
{
    /** @var PostcodeApiNu */
    protected $postcodeApiNu;

    public function setUp(): void
    {
        $this->postcodeApiNu = (new PostcodeApiNu)
            ->setApiKey('qwertyuiop');
    }

    /** @test */
    public function it_can_get_the_default_config_values_for_this_provider()
    {
        $this->assertSame('qwertyuiop', $this->postcodeApiNu->getApiKey());
        $this->assertSame('https://api.postcodeapi.nu/v3/lookup', $this->postcodeApiNu->getRequestUrl());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        $this->expectException(NotSupportedException::class);

        $this->postcodeApiNu->find('1118CP');
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_a_valid_postal_code()
    {
        $address = $this->postcodeApiNu->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"postcode":"6545CA","number":29,"street":"Waldeck Pyrmontsingel","city":"Nijmegen","municipality":"Nijmegen","province":"Gelderland"}')
            ]),
        ]))->findByPostcodeAndHouseNumber('6545CA', '29');

        $this->assertSame('qwertyuiop', $this->postcodeApiNu->getApiKey());
        $this->assertSame('https://api.postcodeapi.nu/v3/lookup/6545CA/29', (string)$this->postcodeApiNu->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => 'Waldeck Pyrmontsingel',
            'house_no' => '29',
            'town' => 'Nijmegen',
            'municipality' => 'Nijmegen',
            'province' => 'Gelderland',
            'latitude' => null,
            'longitude' => null
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_an_invalid_postal_code()
    {
        $address = $this->postcodeApiNu->setHttpClient(new Client([
            'handler' => MockHandler::createWithMiddleware([
                new Response(400, [], '{"title":"Request validation failed","invalidParams":[{"name":"postcode","reason":"should match pattern \"^[0-9]{4}[a-zA-Z]{2}$\""},{"name":"number","reason":"should be integer"}]}')
            ]),
        ]))->findByPostcodeAndHouseNumber('6545C', '29a');

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => null,
            'municipality' => null,
            'province' => null,
            'latitude' => null,
            'longitude' => null
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_an_invalid_postal_code2()
    {
        $address = $this->postcodeApiNu->setHttpClient(new Client([
            'handler' => MockHandler::createWithMiddleware([
                new Response(404, [], '{"title":"Resource not found"}')
            ]),
        ]))->findByPostcodeAndHouseNumber('6545CA', '299');

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => null,
            'municipality' => null,
            'province' => null,
            'latitude' => null,
            'longitude' => null
        ], $address->toArray());
    }
}
