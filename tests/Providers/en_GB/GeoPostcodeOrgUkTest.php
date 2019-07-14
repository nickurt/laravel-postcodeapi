<?php

namespace nickurt\PostcodeApi\tests\Providers\en_GB;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\tests\TestCase;
use PostcodeApi;

class GeoPostcodeOrkUkTest extends TestCase
{
    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        $postcodeApi = PostcodeApi::create('GeoPostcodeOrgUk')->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"code":"SW1A 1AA","osgb36":{"east":"529090","north":"179645"},"osie":{"east":null,"north":null},"wgs84":{"lat":"51.501009","lon":"-0.141588"},"meta":{"sourcecode":"OSCPO","sourcename":"Ordnance Survey Code Point Open","licence":{"type":"Creative Commons Attribution v.3","url":"http:\/\/creativecommons.org\/licenses\/by\/3.0\/","attribution":"Contains Ordnance Survey data \u00a9 Crown copyright and database right 2012. Contains Royal Mail data \u00a9 Royal Mail copyright and database right 2012"},"quality":"10"}}')
            ]),
        ]))->find('SW1A1AA');

        $this->assertInstanceOf(Address::class, $postcodeApi);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => null,
            'municipality' => null,
            'province' => null,
            'latitude' => '51.501009',
            'longitude' => '-0.141588'
        ], $postcodeApi->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_an_invalid_postal_code()
    {
        $this->markTestSkipped('Todo');
    }
}
