<?php

namespace nickurt\PostcodeApi\tests\Providers\nl_NL;

use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Facades\Http;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\nl_NL\PostcodeNL;
use nickurt\PostcodeApi\tests\TestCase;

class PostcodeNLTest extends TestCase
{
    /** @var PostcodeNL */
    protected $postcodeNL;

    public function setUp(): void
    {
        $this->postcodeNL = (new PostcodeNL)
            ->setRequestUrl('https://api.postcode.nl/rest/addresses/%s/%s')
            ->setApiKey('api-key')
            ->setApiSecret('api-secret');
    }

    public function test_it_can_get_the_default_config_values_for_this_provider()
    {
        $this->assertSame('api-key', $this->postcodeNL->getApiKey());
        $this->assertSame('api-secret', $this->postcodeNL->getApiSecret());
        $this->assertSame('https://api.postcode.nl/rest/addresses/%s/%s', $this->postcodeNL->getRequestUrl());
    }

    public function test_it_can_get_the_correct_values_for_find_by_postcode_and_house_number_a_valid_postal_code()
    {
        Http::fake(['https://api.postcode.nl/rest/addresses/1118CP/202' => Http::response('{"street":"Evert van de Beekstraat","houseNumber":202,"houseNumberAddition":"","postcode":"1118CP","city":"Schiphol","municipality":"Haarlemmermeer","province":"Noord-Holland","rdX":111396,"rdY":479739,"latitude":52.30389933,"longitude":4.74791023,"bagNumberDesignationId":"0394200001001951","bagAddressableObjectId":"0394010001001991","addressType":"building","purposes":["office"],"surfaceArea":16800,"houseNumberAdditions":[""]}')]);

        $address = $this->postcodeNL->findByPostcodeAndHouseNumber('1118CP', '202');

        $this->assertSame('api-key', $this->postcodeNL->getApiKey());
        $this->assertSame('api-secret', $this->postcodeNL->getApiSecret());
        $this->assertSame('https://api.postcode.nl/rest/addresses/1118CP/202', $this->postcodeNL->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => 'Evert van de Beekstraat',
            'house_no' => '202',
            'town' => 'Schiphol',
            'municipality' => 'Haarlemmermeer',
            'province' => 'Noord-Holland',
            'latitude' => 52.30389933,
            'longitude' => 4.74791023,
        ], $address->toArray());
    }

    public function test_it_can_get_the_correct_values_for_find_by_postcode_and_house_number_an_invalid_postal_code()
    {
        Http::fake(['https://api.postcode.nl/rest/addresses/1118CP/1' => fn () => throw new HttpClientException('{"exception":"Combination does not exist.","exceptionId":"PostcodeNl_Service_PostcodeAddress_AddressNotFoundException"}', 404)]);

        // GuzzleHttp\Exception\ClientException: Client error: `GET https://json.api-postcode.nl?postcode=1118CP&number=1` resulted in a `404 Not Found` response:
        // {"error":"Cannot resolve address for postcode: 1118CP"}

        $address = $this->postcodeNL->findByPostcodeAndHouseNumber('1118CP', '1');

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
