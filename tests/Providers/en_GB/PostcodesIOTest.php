<?php

namespace nickurt\PostcodeApi\tests\Providers\en_GB;

use Illuminate\Support\Facades\Http;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Exception\NotSupportedException;
use nickurt\PostcodeApi\Providers\en_GB\PostcodesIO;
use nickurt\PostcodeApi\tests\TestCase;

class PostcodesIOTest extends TestCase
{
    /** @var PostcodesIO */
    protected $postcodesIO;

    public function setUp(): void
    {
        $this->postcodesIO = (new PostcodesIO)
            ->setRequestUrl('https://api.postcodes.io/postcodes?q=%s');
    }

    public function test_it_can_get_the_default_config_values_for_this_provider()
    {
        $this->assertSame(null, $this->postcodesIO->getApiKey());
        $this->assertSame('https://api.postcodes.io/postcodes?q=%s', $this->postcodesIO->getRequestUrl());
    }

    public function test_it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        Http::fake(['https://api.postcodes.io/postcodes?q=SW1A1AA' => Http::response('{"status":200,"result":[{"postcode":"SW1A 1AA","quality":1,"eastings":529090,"northings":179645,"country":"England","nhs_ha":"London","longitude":-0.141588,"latitude":51.501009,"european_electoral_region":"London","primary_care_trust":"Westminster","region":"London","lsoa":"Westminster 018C","msoa":"Westminster 018","incode":"1AA","outcode":"SW1A","parliamentary_constituency":"Cities of London and Westminster","admin_district":"Westminster","parish":"Westminster, unparished area","admin_county":null,"admin_ward":"St James\'s","ced":null,"ccg":"NHS Central London (Westminster)","nuts":"Westminster","codes":{"admin_district":"E09000033","admin_county":"E99999999","admin_ward":"E05000644","parish":"E43000236","parliamentary_constituency":"E14000639","ccg":"E38000031","ced":"E99999999","nuts":"UKI32"}}]}')]);

        $address = $this->postcodesIO->find('SW1A1AA');

        $this->assertSame('https://api.postcodes.io/postcodes?q=SW1A1AA', $this->postcodesIO->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'London',
            'municipality' => null,
            'province' => null,
            'latitude' => 51.501009,
            'longitude' => -0.141588,
        ], $address->toArray());
    }

    public function test_it_can_get_the_correct_values_for_find_an_invalid_postal_code()
    {
        Http::fake(['https://api.postcodes.io/postcodes?q=QW1A1AA' => Http::response('{"status":200,"result":null}')]);

        $address = $this->postcodesIO->find('QW1A1AA');

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

        $this->postcodesIO->findByPostcodeAndHouseNumber('QW1A2AA', '1');
    }
}
