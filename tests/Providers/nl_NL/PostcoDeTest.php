<?php

namespace nickurt\PostcodeApi\tests\Providers\nl_NL;

use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Facades\Http;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Exception\NotSupportedException;
use nickurt\PostcodeApi\Providers\nl_NL\PostcoDe;
use nickurt\PostcodeApi\tests\TestCase;

class PostcoDeTest extends TestCase
{
    /** @var PostcoDe */
    protected $postcoDe;

    public function setUp(): void
    {
        $this->postcoDe = (new PostcoDe)
            ->setRequestUrl('https://api.postco.de/v1/postcode/%s/%s');
    }

    public function test_it_can_get_the_default_config_values_for_this_provider()
    {
        $this->assertSame(null, $this->postcoDe->getApiKey());
        $this->assertSame('https://api.postco.de/v1/postcode/%s/%s', $this->postcoDe->getRequestUrl());
    }

    public function test_it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        $this->expectException(NotSupportedException::class);

        $this->postcoDe->find('1118CP');
    }

    public function test_it_can_get_the_correct_values_for_find_by_postcode_and_house_number_a_valid_postal_code()
    {
        Http::fake(['https://api.postco.de/v1/postcode/1118CP/202' => Http::response('{"street":"Evert van de Beekstraat","city":"Schiphol","municipality":"Haarlemmermeer","province":"Noord-Holland","postcode":"1118CP","pnum":"1118","pchar":"CP","rd_x":"111361.82633333333333333333","rd_y":"479700.34883333333333333333","lat":"52.3035437835548","lng":"4.7474064734608"}')]);

        $address = $this->postcoDe->findByPostcodeAndHouseNumber('1118CP', '202');

        $this->assertSame('https://api.postco.de/v1/postcode/1118CP/202', $this->postcoDe->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => 'Evert van de Beekstraat',
            'house_no' => '202',
            'town' => 'Schiphol',
            'municipality' => 'Haarlemmermeer',
            'province' => 'Noord-Holland',
            'latitude' => 52.3035437835548,
            'longitude' => 4.7474064734608,
        ], $address->toArray());
    }

    public function test_it_can_get_the_correct_values_for_find_by_postcode_and_house_number_an_invalid_postal_code()
    {
        Http::fake(['https://api.postco.de/v1/postcode/XXXXAB/1' => fn () => throw new HttpClientException('{"error":"No results"}', 404)]);

        // GuzzleHttp\Exception\ClientException: Client error: `GET https://api.postco.de/v1/postcode/XXXXAB/1` resulted in a `404 Not Found` response:
        // {"error":"No results"}

        $address = $this->postcoDe->findByPostcodeAndHouseNumber('XXXXAB', '1');

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
