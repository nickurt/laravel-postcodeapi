<?php

namespace nickurt\PostcodeApi\tests\Providers\de_DE;

use Illuminate\Support\Facades\Http;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Exception\NotSupportedException;
use nickurt\PostcodeApi\Providers\de_DE\ZippopotamusDE;
use nickurt\PostcodeApi\tests\TestCase;

class ZippopotamusDETest extends TestCase
{
    /** @var ZippopotamusDE */
    protected $zippo;

    public function setUp(): void
    {
        $this->zippo = (new ZippopotamusDE)
            ->setRequestUrl('https://api.zippopotam.us/de/%s')
            ->setApiKey('');
    }

    public function test_it_can_get_the_default_config_values_for_this_provider()
    {
        $this->assertSame('', $this->zippo->getApiKey());
        $this->assertSame('https://api.zippopotam.us/de/%s', $this->zippo->getRequestUrl());
    }

    public function test_it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        Http::fake(['https://api.zippopotam.us/de/07751' => Http::response('{"post code": "07751", "country": "Germany", "country abbreviation": "DE", "places": [ {"place name": "Bucha", "longitude": "11.5167", "state": "Th\u00fcringen", "state abbreviation": "TH", "latitude": "50.8833"} ]} ')]);

        $address = $this->zippo->find('07751');

        $this->assertSame('', $this->zippo->getApiKey());
        $this->assertSame('https://api.zippopotam.us/de/07751', $this->zippo->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Bucha',
            'municipality' => null,
            'province' => 'Thüringen',
            'latitude' => 50.8833,
            'longitude' => 11.5167,
        ], $address->toArray());
    }

    public function test_it_can_get_the_correct_values_for_find_an_invalid_postal_code()
    {
        Http::fake(['https://api.zippopotam.us/de/1234' => Http::response('{}')]);

        $address = $this->zippo->find('1234');

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

        $this->zippo->findByPostcodeAndHouseNumber('1000', '1');
    }
}
