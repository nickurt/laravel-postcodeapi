<?php

namespace nickurt\PostcodeApi\tests\Providers\nl_BE;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Exception\NotSupportedException;
use nickurt\PostcodeApi\Providers\nl_BE\Pro6PP_BE;
use nickurt\PostcodeApi\tests\Providers\BaseProviderTest;

class Pro6PP_BETest extends BaseProviderTest
{
    /** @var Pro6PP_BE */
    protected $pro6PP_BE;

    public function setUp(): void
    {
        $this->pro6PP_BE = (new Pro6PP_BE)
            ->setRequestUrl('https://api.pro6pp.nl/v1/autocomplete?auth_key=%s&be_fourpp=%s')
            ->setApiKey('qwertyuiop');
    }

    /** @test */
    public function it_can_get_the_default_config_values_for_this_provider()
    {
        $this->assertSame('qwertyuiop', $this->pro6PP_BE->getApiKey());
        $this->assertSame('https://api.pro6pp.nl/v1/autocomplete?auth_key=%s&be_fourpp=%s', $this->pro6PP_BE->getRequestUrl());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        $address = $this->pro6PP_BE->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"status":"ok","results":[{"province_nl":"Brussel","province_fr":"Bruxelles","province":"Brussel","municipality_nl":"Brussel","municipality_fr":"Bruxelles","municipality":"Brussel","city_nl":"Brussel","city_fr":"Bruxelles","city":"Brussel","fourpp":1000,"lat":50.84379,"lng":4.3591}]}')
            ]),
        ]))->find('1000');

        $this->assertSame('qwertyuiop', $this->pro6PP_BE->getApiKey());
        $this->assertSame('https://api.pro6pp.nl/v1/autocomplete?auth_key=qwertyuiop&be_fourpp=1000', $this->pro6PP_BE->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Brussel',
            'municipality' => 'Brussel',
            'province' => 'Brussel',
            'latitude' => 50.84379,
            'longitude' => 4.3591
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_an_invalid_postal_code()
    {
        $address = $this->pro6PP_BE->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"status":"error","error":{"message":"be_fourpp not found"},"results":[]}')
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

        $this->pro6PP_BE->findByPostcodeAndHouseNumber('1000', '1');
    }
}
