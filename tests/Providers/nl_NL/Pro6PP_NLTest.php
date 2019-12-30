<?php

namespace nickurt\PostcodeApi\tests\Providers\nl_NL;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\nl_NL\Pro6PP_NL;
use nickurt\PostcodeApi\tests\Providers\BaseProviderTest;

class Pro6PP_NLTest extends BaseProviderTest
{
    /** @var Pro6PP_NL */
    protected $pro6PP_NL;

    public function setUp(): void
    {
        $this->pro6PP_NL = (new Pro6PP_NL)
            ->setApiKey('qwertyuiop');
    }

    /** @test */
    public function it_can_get_the_default_config_values_for_this_provider()
    {
        $this->assertSame('qwertyuiop', $this->pro6PP_NL->getApiKey());
        $this->assertSame('https://api.pro6pp.nl/v1/autocomplete?auth_key=%s&nl_sixpp=%s', (string)$this->pro6PP_NL->getRequestUrl());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        $address = $this->pro6PP_NL->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"status":"ok","results":[{"nl_sixpp":"1118CP","street":"Evert van de Beekstraat","city":"Schiphol","municipality":"Haarlemmermeer","province":"Noord-Holland","streetnumbers":"202;300-306","lat":52.30295,"lng":4.746278,"areacode":"020"}]}')
            ]),
        ]))->find('1118CP');

        $this->assertSame('https://api.pro6pp.nl/v1/autocomplete?auth_key=qwertyuiop&nl_sixpp=1118CP', (string)$this->pro6PP_NL->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => 'Evert van de Beekstraat',
            'house_no' => null,
            'town' => 'Schiphol',
            'municipality' => 'Haarlemmermeer',
            'province' => 'Noord-Holland',
            'latitude' => 52.30295,
            'longitude' => 4.746278
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_an_invalid_postal_code()
    {
        $address = $this->pro6PP_NL->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"status":"error","error":{"message":"Invalid nl_sixpp format"},"results":[]}')
            ]),
        ]))->find('XXXXAB');

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
        $address = $this->pro6PP_NL->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"status":"ok","results":[{"nl_sixpp":"1118CP","street":"Evert van de Beekstraat","street_nen5825":"Evert van de Beekstraat","city":"Schiphol","municipality":"Haarlemmermeer","province":"Noord-Holland","streetnumbers":"202;300-306","lat":52.3038977,"lng":4.7479069,"areacode":"020","surface":16800,"functions":["kantoorfunctie"],"construction_year":2007}]}')
            ]),
        ]))->findByPostcodeAndHouseNumber('1118CP', '202');

        $this->assertSame('https://api.pro6pp.nl/v1/autocomplete?auth_key=qwertyuiop&nl_sixpp=1118CP&streetnumber=202', (string)$this->pro6PP_NL->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => 'Evert van de Beekstraat',
            'house_no' => '202',
            'town' => 'Schiphol',
            'municipality' => 'Haarlemmermeer',
            'province' => 'Noord-Holland',
            'latitude' => 52.3038977,
            'longitude' => 4.7479069
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_an_invalid_postal_code()
    {
        $address = $this->pro6PP_NL->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"status":"error","error":{"message":"Streetnumber not found"},"results":[]}')
            ]),
        ]))->findByPostcodeAndHouseNumber('1118CP', '1');

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
