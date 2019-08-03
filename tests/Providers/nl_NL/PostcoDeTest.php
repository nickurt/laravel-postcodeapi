<?php

namespace nickurt\PostcodeApi\tests\Providers\nl_NL;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Exception\NotSupportedException;
use nickurt\PostcodeApi\ProviderFactory as PostcodeApi;
use nickurt\PostcodeApi\Providers\nl_NL\PostcoDe;
use nickurt\PostcodeApi\tests\TestCase;

class PostcoDeTest extends TestCase
{
    /** @var PostcoDe */
    protected $postcoDe;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->postcoDe = PostcodeApi::create('PostcoDe');
    }

    /** @test */
    public function it_can_get_the_default_config_values_for_this_provider()
    {
        $this->assertSame('', $this->postcoDe->getApiKey());
        $this->assertSame('https://api.postco.de/v1/postcode/%s/%s', $this->postcoDe->getRequestUrl());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        $this->expectException(NotSupportedException::class);

        $this->postcoDe->find('1118CP');
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_a_valid_postal_code()
    {
        $address = $this->postcoDe->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"street":"Evert van de Beekstraat","city":"Schiphol","municipality":"Haarlemmermeer","province":"Noord-Holland","postcode":"1118CP","pnum":"1118","pchar":"CP","rd_x":"111361.82633333333333333333","rd_y":"479700.34883333333333333333","lat":"52.3035437835548","lon":"4.7474064734608"}')
            ]),
        ]))->findByPostcodeAndHouseNumber('1118CP', '202');

        $this->assertSame('https://api.postco.de/v1/postcode/1118CP/202', $this->postcoDe->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => 'Evert van de Beekstraat',
            'house_no' => '202',
            'town' => 'Schiphol',
            'municipality' => 'Haarlemmermeer',
            'province' => 'Noord-Holland',
            'latitude' => 52.3035437835548,
            'longitude' => 4.7474064734608
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_an_invalid_postal_code()
    {
        // GuzzleHttp\Exception\ClientException: Client error: `GET https://api.postco.de/v1/postcode/XXXXAB/1` resulted in a `404 Not Found` response:
        // {"error":"No results"}

        $address = $this->postcoDe->setHttpClient(new Client([
            'handler' => MockHandler::createWithMiddleware([
                new Response(404, [], '{"error":"No results"}')
            ]),
        ]))->findByPostcodeAndHouseNumber('XXXXAB', '1');

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => null,
            'municipality' => null,
            'province' => null,
            'latitude' => null,
            'longitude' => null
        ], $address->toArray());
    }
}
