<?php

namespace nickurt\PostcodeApi\tests\Providers\en_GB;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Exception\NotSupportedException;
use nickurt\PostcodeApi\ProviderFactory as PostcodeApi;
use nickurt\PostcodeApi\Providers\en_GB\UkPostcodes;
use nickurt\PostcodeApi\tests\TestCase;

class UkPostcodesTest extends TestCase
{
    /** @var UkPostcodes */
    protected $ukPostcodes;

    public function setUp(): void
    {
        parent::setUp();

        $this->ukPostcodes = PostcodeApi::create('UkPostcodes');
    }

    /** @test */
    public function it_can_get_the_default_config_values_for_this_provider()
    {
        $this->assertSame('', $this->ukPostcodes->getApiKey());
        $this->assertSame('http://uk-postcodes.com/postcode/%s.json', $this->ukPostcodes->getRequestUrl());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        $address = $this->ukPostcodes->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"postcode":"SW1A 1AA","geo":{"lat":51.501009174414,"lng":-0.14157319687256,"easting":529090,"northing":179645,"geohash":"http://geohash.org/gcpuuz2zj5gq"},"administrative":{"council":{"title":"City of Westminster","uri":"http://statistics.data.gov.uk/id/statistical-geography/E09000033","code":"E09000033"},"ward":{"title":"St. James\'s","uri":"http://statistics.data.gov.uk/id/statistical-geography/E05000644","code":"E05000644"},"constituency":{"title":"Cities of London and Westminster","uri":"http://statistics.data.gov.uk/id/statistical-geography/E14000639","code":"E14000639"}}}')
            ]),
        ]))->find('SW1A1AA');

        $this->assertSame('http://uk-postcodes.com/postcode/SW1A1AA.json', $this->ukPostcodes->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => null,
            'municipality' => null,
            'province' => null,
            'latitude' => 51.501009174414,
            'longitude' => -0.14157319687256
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_an_invalid_postal_code()
    {
        $this->markTestSkipped('Todo');
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_a_valid_postal_code()
    {
        $this->expectException(NotSupportedException::class);

        $this->ukPostcodes->findByPostcodeAndHouseNumber('SW1A2AA', '10 ');
    }
}
