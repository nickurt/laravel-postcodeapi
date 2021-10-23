<?php

namespace nickurt\PostcodeApi\tests\Providers\de_DE;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Exception\NotSupportedException;
use nickurt\PostcodeApi\Providers\de_DE\ZippopotamusDE;
use nickurt\PostcodeApi\tests\Providers\BaseProviderTest;

class ZippopotamusDETest extends BaseProviderTest
{
    /** @var ZippopotamusDE */
    protected $zippo;

    public function setUp(): void
    {
        $this->zippo = (new ZippopotamusDE)
            ->setRequestUrl('https://http://api.zippopotam.us/de/%s')
            ->setApiKey('');
    }

    /** @test */
    public function it_can_get_the_default_config_values_for_this_provider()
    {
        $this->assertSame('', $this->zippo->getApiKey());
        $this->assertSame('https://http://api.zippopotam.us/de/%s', $this->zippo->getRequestUrl());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        $address = $this->zippo->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"post code": "07751", "country": "Germany", "country abbreviation": "DE", "places": [ {"place name": "Bucha", "longitude": "11.5167", "state": "Th\u00fcringen", "state abbreviation": "TH", "latitude": "50.8833"} ]} ')
            ]),
        ]))->find('07751');

        $this->assertSame('', $this->zippo->getApiKey());
        $this->assertSame('https://http://api.zippopotam.us/de/07751', $this->zippo->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Bucha',
            'municipality' => null,
            'province' => 'Thüringen',
            'latitude' => 50.8833,
            'longitude' => 11.5167
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_an_invalid_postal_code()
    {
        $address = $this->zippo->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{}')
            ]),
        ]))->find('1234');

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
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_a_valid_postal_code()
    {
        $this->expectException(NotSupportedException::class);

        $this->zippo->findByPostcodeAndHouseNumber('1000', '1');
    }
}
