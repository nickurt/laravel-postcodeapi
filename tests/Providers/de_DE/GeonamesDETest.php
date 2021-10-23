<?php

namespace nickurt\PostcodeApi\tests\Providers\de_DE;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\de_DE\GeonamesDE;
use nickurt\PostcodeApi\tests\Providers\BaseProviderTest;

class GeonamesDETest extends BaseProviderTest
{
    /** @var GeonamesDE */
    protected $geonames;

    public function setUp(): void
    {
        $this->geonames = (new GeonamesDE)
            ->setRequestUrl('https://api.geonames.org/postalCodeLookupJSON?postalcode=%s&country=DE&username=demo')
            ->setApiKey('');;
    }

    /** @test */
    public function it_can_get_the_default_config_values_for_this_provider()
    {
        $this->assertSame('', $this->geonames->getApiKey());
        $this->assertSame('https://api.geonames.org/postalCodeLookupJSON?postalcode=%s&country=DE&username=demo', $this->geonames->getRequestUrl());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        $address = $this->geonames->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"postalcodes":[{"adminCode2":"00","adminCode3":"16074","adminName3":"Saale-Holzland-Kreis","adminCode1":"TH","lng":11.5166667,"countryCode":"DE","postalCode":"07751","adminName1":"Thüringen","ISO3166-2":"TH","placeName":"Bucha","lat":50.8833333}]}')
            ]),
        ]))->find('07751');

        $this->assertSame('', $this->geonames->getApiKey());
        $this->assertSame('https://api.geonames.org/postalCodeLookupJSON?postalcode=07751&country=DE&username=demo', $this->geonames->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Bucha',
            'municipality' => 'Saale-Holzland-Kreis',
            'province' => 'Thüringen',
            'latitude' => 50.8833333,
            'longitude' => 11.5166667
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_an_invalid_postal_code()
    {
        $address = $this->geonames->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"postalcodes":[]}')
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
        $address = $this->geonames->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"postalcodes":[{"adminCode2":"00","adminCode3":"16074","adminName3":"Saale-Holzland-Kreis","adminCode1":"TH","lng":11.5166667,"countryCode":"DE","postalCode":"07751","adminName1":"Thüringen","ISO3166-2":"TH","placeName":"Bucha","lat":50.8833333}]}')
            ]),
        ]))->findByPostcodeAndHouseNumber('07751', 'Bucha');

        $this->assertSame('', $this->geonames->getApiKey());
        $this->assertSame('https://api.geonames.org/postalCodeLookupJSON?postalcode=07751&placename=Bucha&country=DE&username=demo', $this->geonames->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Bucha',
            'municipality' => 'Saale-Holzland-Kreis',
            'province' => 'Thüringen',
            'latitude' => 50.8833333,
            'longitude' => 11.5166667
        ], $address->toArray());

    }
}
