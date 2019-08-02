<?php

namespace nickurt\PostcodeApi\tests\Providers\nl_NL;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\tests\TestCase;
use PostcodeApi;

class ApiPostcodeTest extends TestCase
{
    /** @var \nickurt\postcodeapi\Providers\nl_NL\ApiPostcode */
    protected $apiPostcode;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->apiPostcode = PostcodeApi::create('ApiPostcode');
        $this->apiPostcode->setApiKey('c56a4180-65aa-42ec-a945-5fd21dec0538');
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_a_valid_postal_code()
    {
        $address = $this->apiPostcode->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"street":"Evert van de Beekstraat","postcode":"1118CP","house_number":"202","city":"Schiphol","longitude":"4.7479072","latitude":"52.3038976","province":"Noord-Holland"}')
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
            'longitude' => 4.7479072
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_an_invalid_postal_code()
    {
        $this->markTestSkipped('Todo');

        // GuzzleHttp\Exception\ClientException: Client error: `GET http://json.api-postcode.nl?postcode=XXXXAB` resulted in a `400 Bad Request` response:
        // {"error":"Given postcode incorrect"}

        // GuzzleHttp\Exception\ClientException: Client error: `GET http://json.api-postcode.nl?postcode=XXXXAB` resulted in a `401 Unauthorized` response:
        // {"error":"Access denied"}
    }
}
