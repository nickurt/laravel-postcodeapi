<?php

namespace nickurt\PostcodeApi\tests\Providers\en_GB;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Exception\NotSupportedException;
use nickurt\PostcodeApi\Providers\en_GB\GeoPostcodeOrgUk;
use nickurt\PostcodeApi\tests\Providers\BaseProviderTest;

class GeoPostcodeOrkUkTest extends BaseProviderTest
{
    /** @var GeoPostcodeOrgUk */
    protected $geoPostcodeOrgUk;

    public function setUp(): void
    {
        $this->geoPostcodeOrgUk = (new GeoPostcodeOrgUk);
    }

    /** @test */
    public function it_can_get_the_default_config_values_for_this_provider()
    {
        $this->assertSame('http://www.geopostcode.org.uk/api/%s.json', (string)$this->geoPostcodeOrgUk->getRequestUrl());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        $address = $this->geoPostcodeOrgUk->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"code":"SW1A 1AA","osgb36":{"east":"529090","north":"179645"},"osie":{"east":null,"north":null},"wgs84":{"lat":"51.501009","lon":"-0.141588"},"meta":{"sourcecode":"OSCPO","sourcename":"Ordnance Survey Code Point Open","licence":{"type":"Creative Commons Attribution v.3","url":"http:\/\/creativecommons.org\/licenses\/by\/3.0\/","attribution":"Contains Ordnance Survey data \u00a9 Crown copyright and database right 2012. Contains Royal Mail data \u00a9 Royal Mail copyright and database right 2012"},"quality":"10"}}')
            ]),
        ]))->find('SW1A1AA');

        $this->assertSame('http://www.geopostcode.org.uk/api/SW1A1AA.json', (string)$this->geoPostcodeOrgUk->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => null,
            'municipality' => null,
            'province' => null,
            'latitude' => 51.501009,
            'longitude' => -0.141588
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_an_invalid_postal_code()
    {
        // GuzzleHttp\Exception\ClientException: Client error: `GET http://www.geopostcode.org.uk/api/XW2A2AA.json` resulted in a `404 Not found` response:
        // Postcode not found

        $address = $this->geoPostcodeOrgUk->setHttpClient(new Client([
            'handler' => MockHandler::createWithMiddleware([
                new Response(404, [], 'Postcode not found' . PHP_EOL)
            ])
        ]))->find('XW2A2AA');

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

        $this->geoPostcodeOrgUk->findByPostcodeAndHouseNumber('SW1A1AA', '1');
    }
}
