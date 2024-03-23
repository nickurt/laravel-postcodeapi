<?php

namespace nickurt\PostcodeApi\tests\Providers\nl_NL;

use Illuminate\Support\Facades\Http;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\nl_NL\Pro6PP_NL;
use nickurt\PostcodeApi\tests\TestCase;

class Pro6PP_NLTest extends TestCase
{
    /** @var Pro6PP_NL */
    protected $pro6PP_NL;

    public function setUp(): void
    {
        $this->pro6PP_NL = (new Pro6PP_NL)
            ->setRequestUrl('https://api.pro6pp.nl/v1/autocomplete?auth_key=%s&nl_sixpp=%s')
            ->setApiKey('qwertyuiop');
    }

    public function test_it_can_get_the_default_config_values_for_this_provider()
    {
        $this->assertSame('qwertyuiop', $this->pro6PP_NL->getApiKey());
        $this->assertSame('https://api.pro6pp.nl/v1/autocomplete?auth_key=%s&nl_sixpp=%s', $this->pro6PP_NL->getRequestUrl());
    }

    public function test_it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        Http::fake(['https://api.pro6pp.nl/v1/autocomplete?auth_key=qwertyuiop&nl_sixpp=1118CP' => Http::response('{"status":"ok","results":[{"nl_sixpp":"1118CP","street":"Evert van de Beekstraat","city":"Schiphol","municipality":"Haarlemmermeer","province":"Noord-Holland","streetnumbers":"202;300-306","lat":52.30295,"lng":4.746278,"areacode":"020"}]}')]);

        $address = $this->pro6PP_NL->find('1118CP');

        $this->assertSame('qwertyuiop', $this->pro6PP_NL->getApiKey());
        $this->assertSame('https://api.pro6pp.nl/v1/autocomplete?auth_key=qwertyuiop&nl_sixpp=1118CP', $this->pro6PP_NL->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => 'Evert van de Beekstraat',
            'house_no' => null,
            'town' => 'Schiphol',
            'municipality' => 'Haarlemmermeer',
            'province' => 'Noord-Holland',
            'latitude' => 52.30295,
            'longitude' => 4.746278,
        ], $address->toArray());
    }

    public function test_it_can_get_the_correct_values_for_find_a_valid_postal_code_without_coordinates()
    {
        Http::fake(['https://api.pro6pp.nl/v1/autocomplete?auth_key=qwertyuiop&nl_sixpp=4493ZG' => Http::response('{"status":"ok","results":[{"nl_sixpp":"4493ZG","street":"Postbus","street_nen5825":"Postbus","city":"Kamperland","municipality":"Noord-Beveland","province":"Zeeland","lat":null,"lng":null,"areacode":"0113","surface":null,"functions":null,"construction_year":null}]}')]);

        $address = $this->pro6PP_NL->find('4493ZG');

        $this->assertSame('qwertyuiop', $this->pro6PP_NL->getApiKey());
        $this->assertSame('https://api.pro6pp.nl/v1/autocomplete?auth_key=qwertyuiop&nl_sixpp=4493ZG', $this->pro6PP_NL->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => 'Postbus',
            'house_no' => null,
            'town' => 'Kamperland',
            'municipality' => 'Noord-Beveland',
            'province' => 'Zeeland',
            'latitude' => null,
            'longitude' => null,
        ], $address->toArray());
    }

    public function test_it_can_get_the_correct_values_for_find_an_invalid_postal_code()
    {
        Http::fake(['https://api.pro6pp.nl/v1/autocomplete?auth_key=qwertyuiop&nl_sixpp=XXXXAB' => Http::response('{"status":"error","error":{"message":"Invalid nl_sixpp format"},"results":[]}')]);

        $address = $this->pro6PP_NL->find('XXXXAB');

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

    public function test_it_can_get_the_correct_values_for_find_by_postcode_and_house_number_a_valid_postal_code()
    {
        Http::fake(['https://api.pro6pp.nl/v1/autocomplete?auth_key=qwertyuiop&nl_sixpp=1118CP&streetnumber=202' => Http::response('{"status":"ok","results":[{"nl_sixpp":"1118CP","street":"Evert van de Beekstraat","street_nen5825":"Evert van de Beekstraat","city":"Schiphol","municipality":"Haarlemmermeer","province":"Noord-Holland","streetnumbers":"202;300-306","lat":52.3038977,"lng":4.7479069,"areacode":"020","surface":16800,"functions":["kantoorfunctie"],"construction_year":2007}]}')]);

        $address = $this->pro6PP_NL->findByPostcodeAndHouseNumber('1118CP', '202');

        $this->assertSame('qwertyuiop', $this->pro6PP_NL->getApiKey());
        $this->assertSame('https://api.pro6pp.nl/v1/autocomplete?auth_key=qwertyuiop&nl_sixpp=1118CP&streetnumber=202', $this->pro6PP_NL->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => 'Evert van de Beekstraat',
            'house_no' => '202',
            'town' => 'Schiphol',
            'municipality' => 'Haarlemmermeer',
            'province' => 'Noord-Holland',
            'latitude' => 52.3038977,
            'longitude' => 4.7479069,
        ], $address->toArray());
    }

    public function test_it_can_get_the_correct_values_for_find_by_postcode_and_house_number_a_valid_postal_code_without_coordinates()
    {
        Http::fake(['https://api.pro6pp.nl/v1/autocomplete?auth_key=qwertyuiop&nl_sixpp=4493ZG&streetnumber=35' => Http::response('{"status":"ok","results":[{"nl_sixpp":"4493ZG","street":"Postbus","street_nen5825":"Postbus","city":"Kamperland","municipality":"Noord-Beveland","province":"Zeeland","lat":null,"lng":null,"areacode":"0113","surface":null,"functions":null,"construction_year":null}]}')]);

        $address = $this->pro6PP_NL->findByPostcodeAndHouseNumber('4493ZG', '35');

        $this->assertSame('qwertyuiop', $this->pro6PP_NL->getApiKey());
        $this->assertSame('https://api.pro6pp.nl/v1/autocomplete?auth_key=qwertyuiop&nl_sixpp=4493ZG&streetnumber=35', $this->pro6PP_NL->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => 'Postbus',
            'house_no' => '35',
            'town' => 'Kamperland',
            'municipality' => 'Noord-Beveland',
            'province' => 'Zeeland',
            'latitude' => null,
            'longitude' => null,
        ], $address->toArray());
    }

    public function test_it_can_get_the_correct_values_for_find_by_postcode_and_house_number_an_invalid_postal_code()
    {
        Http::fake(['https://api.pro6pp.nl/v1/autocomplete?auth_key=qwertyuiop&nl_sixpp=1118CP&streetnumber=1' => Http::response('{"status":"error","error":{"message":"Streetnumber not found"},"results":[]}')]);

        $address = $this->pro6PP_NL->findByPostcodeAndHouseNumber('1118CP', '1');

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
