<?php

namespace nickurt\PostcodeApi\tests\Providers\nl_NL;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\tests\TestCase;
use PostcodeApi;

class PostcodesNLTest extends TestCase
{
    /** @var \nickurt\postcodeapi\Providers\nl_NL\PostcodesNL */
    protected $postcodesNL;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->postcodesNL = PostcodeApi::create('PostcodesNL');
        $this->postcodesNL->setApiKey('qwertyuiopasdfghjklzxcvbnmqwertyuiopasdfghjklzxcvbnmqwertyuiopas');
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        $address = $this->postcodesNL->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"status":"ok","results":[{"nlzip6":"1118CP","streetname":"Evert van de Beekstraat","city":"Schiphol","municipality":"Haarlemmermeer","province":"Noord-Holland","latitude":"52.303047","longitude":"4.746179","phoneareacode":"020"}]}')
            ]),
        ]))->find('1118CP');

        $this->assertSame('qwertyuiopasdfghjklzxcvbnmqwertyuiopasdfghjklzxcvbnmqwertyuiopas', $this->postcodesNL->getApiKey());
        $this->assertSame('http://api.postcodes.nl/1.0/address?apikey=qwertyuiopasdfghjklzxcvbnmqwertyuiopasdfghjklzxcvbnmqwertyuiopas&nlzip6=1118CP', $this->postcodesNL->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => 'Evert van de Beekstraat',
            'house_no' => null,
            'town' => 'Schiphol',
            'municipality' => 'Haarlemmermeer',
            'province' => 'Noord-Holland',
            'latitude' => 52.303047,
            'longitude' => 4.746179
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_an_invalid_postal_code()
    {
        $address = $this->postcodesNL->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"status":"error","errorcode":103,"errormessage":"invalid nlzip6"}')
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
            'longitude' => null,
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_a_valid_postal_code()
    {
        $address = $this->postcodesNL->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"status":"ok","results":[{"nlzip6":"1118CP","streetname":"Evert van de Beekstraat","city":"Schiphol","municipality":"Haarlemmermeer","province":"Noord-Holland","latitude":"52.303894","longitude":"4.747910","phoneareacode":"020"}]}')
            ]),
        ]))->findByPostcodeAndHouseNumber('1118CP', '202');

        $this->assertSame('qwertyuiopasdfghjklzxcvbnmqwertyuiopasdfghjklzxcvbnmqwertyuiopas', $this->postcodesNL->getApiKey());
        $this->assertSame('http://api.postcodes.nl/1.0/address?apikey=qwertyuiopasdfghjklzxcvbnmqwertyuiopasdfghjklzxcvbnmqwertyuiopas&nlzip6=1118CP&streetnumber=202', $this->postcodesNL->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => 'Evert van de Beekstraat',
            'house_no' => '202',
            'town' => 'Schiphol',
            'municipality' => 'Haarlemmermeer',
            'province' => 'Noord-Holland',
            'latitude' => 52.303894,
            'longitude' => 4.74791
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_an_invalid_postal_code()
    {
        $address = $this->postcodesNL->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"status":"error","errorcode":11,"errormessage":"no results"}')
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
            'longitude' => null,
        ], $address->toArray());
    }
}
