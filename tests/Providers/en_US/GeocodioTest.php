<?php

namespace nickurt\PostcodeApi\tests\Providers\en_US;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Exception\NotSupportedException;
use nickurt\PostcodeApi\ProviderFactory as PostcodeApi;
use nickurt\postcodeapi\Providers\en_US\Geocodio;
use nickurt\PostcodeApi\tests\TestCase;

class GeocodioTest extends TestCase
{
    /** @var Geocodio */
    protected $geocodio;

    public function setUp(): void
    {
        parent::setUp();

        $this->geocodio = PostcodeApi::create('Geocodio');
        $this->geocodio->setApiKey('qwertyuiop');
    }

    /** @test */
    public function it_can_get_the_default_config_values_for_this_provider()
    {
        $this->assertSame('qwertyuiop', $this->geocodio->getApiKey());
        $this->assertSame('https://api.geocod.io/v1.3/geocode/?q=%s&api_key=%s', $this->geocodio->getRequestUrl());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        $address = $this->geocodio->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"input":{"address_components":{"number":"42370","street":"Bob Hope","suffix":"Dr","formatted_street":"Bob Hope Dr","city":"Rancho Mirage","state":"CA","country":"US"},"formatted_address":"42370 Bob Hope Dr, Rancho Mirage, CA"},"results":[{"address_components":{"number":"42370","street":"Bob Hope","suffix":"Dr","formatted_street":"Bob Hope Dr","city":"Rancho Mirage","county":"Riverside County","state":"CA","zip":"92270","country":"US"},"formatted_address":"42370 Bob Hope Dr, Rancho Mirage, CA 92270","location":{"lat":33.73865,"lng":-116.407153},"accuracy":1,"accuracy_type":"rooftop","source":"Riverside"}]}')
            ]),
        ]))->find('42370+Bob+Hope+Drive,+Rancho+Mirage+CA');

        $this->assertSame('qwertyuiop', $this->geocodio->getApiKey());
        $this->assertSame('https://api.geocod.io/v1.3/geocode/?q=42370+Bob+Hope+Drive,+Rancho+Mirage+CA&api_key=qwertyuiop', $this->geocodio->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => 'Bob Hope Dr',
            'house_no' => null,
            'town' => 'Rancho Mirage',
            'municipality' => 'CA',
            'province' => null,
            'latitude' => 33.73865,
            'longitude' => -116.407153
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_an_invalid_postal_code()
    {
        $address = $this->geocodio->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"input":{"address_components":{"zip":"12370","country":"US"},"formatted_address":"12370"},"results":[]}')
            ]),
        ]))->find('12370');

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

        $this->geocodio->findByPostcodeAndHouseNumber('22201', '1109');
    }
}
