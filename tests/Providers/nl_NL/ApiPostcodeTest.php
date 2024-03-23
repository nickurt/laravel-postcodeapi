<?php

namespace nickurt\PostcodeApi\tests\Providers\nl_NL;

use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Facades\Http;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\nl_NL\ApiPostcode;
use nickurt\PostcodeApi\tests\TestCase;

class ApiPostcodeTest extends TestCase
{
    /** @var ApiPostcode */
    protected $apiPostcode;

    public function setUp(): void
    {
        $this->apiPostcode = (new ApiPostcode)
            ->setRequestUrl('https://json.api-postcode.nl')
            ->setApiKey('c56a4180-65aa-42ec-a945-5fd21dec0538');
    }

    public function test_it_can_get_the_default_config_values_for_this_provider()
    {
        $this->assertSame('c56a4180-65aa-42ec-a945-5fd21dec0538', $this->apiPostcode->getApiKey());
        $this->assertSame('https://json.api-postcode.nl', $this->apiPostcode->getRequestUrl());
    }

    public function test_it_can_get_the_correct_values_for_find_by_postcode_and_house_number_a_valid_postal_code()
    {
        Http::fake(['https://json.api-postcode.nl?postcode=1118CP&number=202' => Http::response('{"street":"Evert van de Beekstraat","postcode":"1118CP","house_number":"202","city":"Schiphol","longitude":"4.7479072","latitude":"52.3038976","province":"Noord-Holland"}')]);

        $address = $this->apiPostcode->findByPostcodeAndHouseNumber('1118CP', '202');

        $this->assertSame('c56a4180-65aa-42ec-a945-5fd21dec0538', $this->apiPostcode->getApiKey());
        $this->assertSame('https://json.api-postcode.nl?postcode=1118CP&number=202', $this->apiPostcode->getRequestUrl());

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

    public function test_it_can_get_the_correct_values_for_find_by_postcode_and_house_number_an_invalid_postal_code()
    {
        Http::fake(['https://json.api-postcode.nl?postcode=1118CP&number=1' => fn () => throw new HttpClientException('{"error":"Cannot resolve address for postcode: 1118CP"}', 404)]);

        // GuzzleHttp\Exception\ClientException: Client error: `GET https://json.api-postcode.nl?postcode=1118CP&number=1` resulted in a `404 Not Found` response:
        // {"error":"Cannot resolve address for postcode: 1118CP"}

        $address = $this->apiPostcode->findByPostcodeAndHouseNumber('1118CP', '1');

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

    public function test_it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        Http::fake(['https://json.api-postcode.nl?postcode=1118CP' => Http::response('{"street":"Evert van de Beekstraat","postcode":"1118CP","house_number":"178","city":"Schiphol","longitude":"4.7517046","latitude":"52.3052535","province":"Noord-Holland"}')]);

        $address = $this->apiPostcode->find('1118CP');

        $this->assertSame('c56a4180-65aa-42ec-a945-5fd21dec0538', $this->apiPostcode->getApiKey());
        $this->assertSame('https://json.api-postcode.nl?postcode=1118CP', $this->apiPostcode->getRequestUrl());

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

    public function test_it_can_get_the_correct_values_for_find_an_invalid_postal_code()
    {
        Http::fake(['https://json.api-postcode.nl?postcode=XXXXAB' => fn () => throw new HttpClientException('{"error":"Given postcode incorrect"}', 400)]);

        // GuzzleHttp\Exception\ClientException: Client error: `GET https://json.api-postcode.nl?postcode=XXXXAB` resulted in a `400 Bad Request` response:
        // {"error":"Given postcode incorrect"}

        $address = $this->apiPostcode->find('XXXXAB');

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
