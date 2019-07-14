<?php

namespace nickurt\PostcodeApi\tests\Providers\en_GB;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\tests\TestCase;
use PostcodeApi;

class UkPostcodesTest extends TestCase
{
    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        $postcodeApi = PostcodeApi::create('UkPostcodes')->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"postcode":"SW1A 1AA","geo":{"lat":51.501009174414,"lng":-0.14157319687256,"easting":529090,"northing":179645,"geohash":"http://geohash.org/gcpuuz2zj5gq"},"administrative":{"council":{"title":"City of Westminster","uri":"http://statistics.data.gov.uk/id/statistical-geography/E09000033","code":"E09000033"},"ward":{"title":"St. James\'s","uri":"http://statistics.data.gov.uk/id/statistical-geography/E05000644","code":"E05000644"},"constituency":{"title":"Cities of London and Westminster","uri":"http://statistics.data.gov.uk/id/statistical-geography/E14000639","code":"E14000639"}}}')
            ]),
        ]))->find('SW1A1AA');

        $this->assertInstanceOf(Address::class, $postcodeApi);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => null,
            'municipality' => null,
            'province' => null,
            'latitude' => 51.501009174414,
            'longitude' => -0.14157319687256
        ], $postcodeApi->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_an_invalid_postal_code()
    {
        $this->markTestSkipped('Todo');
    }
}