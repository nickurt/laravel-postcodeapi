<?php

namespace nickurt\PostcodeApi\tests\Providers\en_AU;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Exception\NotSupportedException;
use nickurt\PostcodeApi\Providers\en_AU\PostcodeApiComAu;
use nickurt\PostcodeApi\tests\Providers\BaseProviderTest;

class PostcodeApiComAuTest extends BaseProviderTest
{
    /** @var PostcodeApiComAu */
    protected $postcodeApiComAu;

    public function setUp(): void
    {
        $this->postcodeApiComAu = (new PostcodeApiComAu)
            ->setRequestUrl('http://v0.postcodeapi.com.au/suburbs/%s.json');
    }

    /** @test */
    public function it_can_get_the_default_config_values_for_this_provider()
    {
        $this->assertSame(null, $this->postcodeApiComAu->getApiKey());
        $this->assertSame('http://v0.postcodeapi.com.au/suburbs/%s.json', $this->postcodeApiComAu->getRequestUrl());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        $address = $this->postcodeApiComAu->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '[{"name": "Collingwood", "postcode": 3066, "state": {"name": "Victoria", "abbreviation": "VIC"}, "locality": "HAWTHORN", "latitude": -37.799999999999997, "longitude": 144.98330000000001}]')
            ]),
        ]))->find('3066');

        $this->assertSame('http://v0.postcodeapi.com.au/suburbs/3066.json', $this->postcodeApiComAu->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Collingwood',
            'municipality' => 'Victoria',
            'province' => null,
            'latitude' => -37.8,
            'longitude' => 144.9833
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_an_invalid_postal_code()
    {
        $address = $this->postcodeApiComAu->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '[]')
            ]),
        ]))->find('9065');

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

        $this->postcodeApiComAu->findByPostcodeAndHouseNumber('9065', '125');
    }
}
