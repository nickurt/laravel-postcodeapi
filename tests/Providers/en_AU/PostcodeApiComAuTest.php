<?php

namespace nickurt\PostcodeApi\tests\Providers\en_AU;

use Illuminate\Support\Facades\Http;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Exception\NotSupportedException;
use nickurt\PostcodeApi\Providers\en_AU\PostcodeApiComAu;
use nickurt\PostcodeApi\tests\TestCase;

class PostcodeApiComAuTest extends TestCase
{
    /** @var PostcodeApiComAu */
    protected $postcodeApiComAu;

    public function setUp(): void
    {
        $this->postcodeApiComAu = (new PostcodeApiComAu)
            ->setRequestUrl('https://v0.postcodeapi.com.au/suburbs/%s.json');
    }

    public function test_it_can_get_the_default_config_values_for_this_provider()
    {
        $this->assertSame(null, $this->postcodeApiComAu->getApiKey());
        $this->assertSame('https://v0.postcodeapi.com.au/suburbs/%s.json', $this->postcodeApiComAu->getRequestUrl());
    }

    public function test_it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        Http::fake(['https://v0.postcodeapi.com.au/suburbs/3066.json' => Http::response('[{"name": "Collingwood", "postcode": 3066, "state": {"name": "Victoria", "abbreviation": "VIC"}, "locality": "HAWTHORN", "latitude": -37.799999999999997, "longitude": 144.98330000000001}]')]);

        $address = $this->postcodeApiComAu->find('3066');

        $this->assertSame('https://v0.postcodeapi.com.au/suburbs/3066.json', $this->postcodeApiComAu->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Collingwood',
            'municipality' => 'Victoria',
            'province' => null,
            'latitude' => -37.8,
            'longitude' => 144.9833,
        ], $address->toArray());
    }

    public function test_it_can_get_the_correct_values_for_find_an_invalid_postal_code()
    {
        Http::fake(['https://v0.postcodeapi.com.au/suburbs/9065.json' => Http::response('[]')]);

        $address = $this->postcodeApiComAu->find('9065');

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

        $this->postcodeApiComAu->findByPostcodeAndHouseNumber('9065', '125');
    }
}
