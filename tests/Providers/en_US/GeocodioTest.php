<?php

namespace nickurt\PostcodeApi\tests\Providers\en_US;

use Illuminate\Support\Facades\Http;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Exception\NotSupportedException;
use nickurt\PostcodeApi\Providers\en_US\Geocodio;
use nickurt\PostcodeApi\tests\TestCase;

class GeocodioTest extends TestCase
{
    /** @var Geocodio */
    protected $geocodio;

    public function setUp(): void
    {
        $this->geocodio = (new Geocodio)
            ->setRequestUrl('https://api.geocod.io/v1.3/geocode/?q=%s&api_key=%s')
            ->setApiKey('qwertyuiop');
    }

    public function test_it_can_get_the_default_config_values_for_this_provider()
    {
        $this->assertSame('qwertyuiop', $this->geocodio->getApiKey());
        $this->assertSame('https://api.geocod.io/v1.3/geocode/?q=%s&api_key=%s', $this->geocodio->getRequestUrl());
    }

    public function test_it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        Http::fake(['https://api.geocod.io/v1.3/geocode/?q=92270&api_key=qwertyuiop' => Http::response('{"input":{"address_components":{"zip":"92270","country":"US"},"formatted_address":"92270"},"results":[{"address_components":{"city":"Rancho Mirage","county":"Riverside County","state":"CA","zip":"92270","country":"US"},"formatted_address":"Rancho Mirage, CA 92270","location":{"lat":33.73974,"lng":-116.41279},"accuracy":1,"accuracy_type":"place","source":"TIGER\/Line\u00ae dataset from the US Census Bureau"}]}')]);

        $address = $this->geocodio->find('92270');

        $this->assertSame('qwertyuiop', $this->geocodio->getApiKey());
        $this->assertSame('https://api.geocod.io/v1.3/geocode/?q=92270&api_key=qwertyuiop', $this->geocodio->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Rancho Mirage',
            'municipality' => 'CA',
            'province' => null,
            'latitude' => 33.73974,
            'longitude' => -116.41279,
        ], $address->toArray());
    }

    public function test_it_can_get_the_correct_values_for_find_an_invalid_postal_code()
    {
        Http::fake(['https://api.geocod.io/v1.3/geocode/?q=12370&api_key=qwertyuiop' => Http::response('{"input":{"address_components":{"zip":"12370","country":"US"},"formatted_address":"12370"},"results":[]}')]);

        $address = $this->geocodio->find('12370');

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
        $this->expectException(NotSupportedException::class);

        $this->geocodio->findByPostcodeAndHouseNumber('22201', '1109');
    }
}
