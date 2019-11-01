<?php

namespace nickurt\PostcodeApi\tests\Providers\nl_NL;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\nl_NL\ApiPostcode;
use nickurt\PostcodeApi\tests\Providers\BaseProviderTest;

class ApiPostcodeTest extends BaseProviderTest
{
    /** @var ApiPostcode */
    protected $apiPostcode;

    public function setUp(): void
    {
        $this->apiPostcode = (new ApiPostcode)
            ->setRequestUrl('http://json.api-postcode.nl')
            ->setApiKey('c56a4180-65aa-42ec-a945-5fd21dec0538');
    }

    /** @test */
    public function it_can_get_the_default_config_values_for_this_provider()
    {
        $this->assertSame('c56a4180-65aa-42ec-a945-5fd21dec0538', $this->apiPostcode->getApiKey());
        $this->assertSame('http://json.api-postcode.nl', $this->apiPostcode->getRequestUrl());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_a_valid_postal_code()
    {
        $address = $this->apiPostcode->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"street":"Evert van de Beekstraat","postcode":"1118CP","house_number":"202","city":"Schiphol","longitude":"4.7479072","latitude":"52.3038976","province":"Noord-Holland"}'),
            ]),
        ]))->findByPostcodeAndHouseNumber('1118CP', '202');

        $this->assertSame('c56a4180-65aa-42ec-a945-5fd21dec0538', $this->apiPostcode->getApiKey());
        $this->assertSame('http://json.api-postcode.nl?postcode=1118CP&number=202', $this->apiPostcode->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => 'Evert van de Beekstraat',
            'house_no' => '202',
            'town' => 'Schiphol',
            'municipality' => null,
            'province' => 'Noord-Holland',
            'latitude' => 52.3038976,
            'longitude' => 4.7479072,
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_an_invalid_postal_code()
    {
        // GuzzleHttp\Exception\ClientException: Client error: `GET http://json.api-postcode.nl?postcode=1118CP&number=1` resulted in a `404 Not Found` response:
        // {"error":"Cannot resolve address for postcode: 1118CP"}

        $address = $this->apiPostcode->setHttpClient(new Client([
            'handler' => MockHandler::createWithMiddleware([
                new Response(404, [], '{"error":"Cannot resolve address for postcode: 1118CP"}'),
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

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        $address = $this->apiPostcode->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"street":"Evert van de Beekstraat","postcode":"1118CP","house_number":"178","city":"Schiphol","longitude":"4.7517046","latitude":"52.3052535","province":"Noord-Holland"}'),
            ]),
        ]))->find('1118CP');

        $this->assertSame('c56a4180-65aa-42ec-a945-5fd21dec0538', $this->apiPostcode->getApiKey());
        $this->assertSame('http://json.api-postcode.nl?postcode=1118CP', $this->apiPostcode->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => 'Evert van de Beekstraat',
            'house_no' => null,
            'town' => 'Schiphol',
            'municipality' => null,
            'province' => 'Noord-Holland',
            'latitude' => 52.3052535,
            'longitude' => 4.7517046,
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_an_invalid_postal_code()
    {
        // GuzzleHttp\Exception\ClientException: Client error: `GET http://json.api-postcode.nl?postcode=XXXXAB` resulted in a `400 Bad Request` response:
        // {"error":"Given postcode incorrect"}

        $address = $this->apiPostcode->setHttpClient(new Client([
            'handler' => MockHandler::createWithMiddleware([
                new Response(400, [], '{"error":"Given postcode incorrect"}'),
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
}
