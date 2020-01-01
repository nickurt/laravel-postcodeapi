<?php

namespace nickurt\PostcodeApi\tests\Providers\nl_NL;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Exceptions\NotSupportedException;
use nickurt\PostcodeApi\Providers\nl_NL\PostcodeData;
use nickurt\PostcodeApi\tests\Providers\BaseProviderTest;

class PostcodeDataTest extends BaseProviderTest
{
    /** @var PostcodeData */
    protected $postcodeData;

    /** @var \nickurt\PostcodeApi\Http\Guzzle6HttpClient */
    protected $httpClient;

    public function setUp(): void
    {
        $this->postcodeData = (new PostcodeData($this->httpClient = new \nickurt\PostcodeApi\Http\Guzzle6HttpClient()));
    }

    /** @test */
    public function it_can_get_the_default_config_values_for_this_provider()
    {
        $this->assertSame('http://api.postcodedata.nl/v1/postcode/?postcode=%s&streetnumber=%s&ref=%s', $this->postcodeData->getRequestUrl());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        $this->expectException(NotSupportedException::class);

        $this->postcodeData->find('1118CP');
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_a_valid_postal_code()
    {
        $_SERVER['HTTP_HOST'] = 'localhost';

        $this->httpClient->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"status":"ok","details":[{"street":"Evert van de Beekstraat","city":"Schiphol","municipality":"Haarlemmermeer","province":"Noord-Holland","postcode":"1118 CP","pnum":"1118","pchar":"CP","rd_x":"111361.82633333333333333333","rd_y":"479700.34883333333333333333","lat":"52.3035437835548","lon":"4.7474064734608"}]}')
            ]),
        ]));

        $address = $this->postcodeData->findByPostcodeAndHouseNumber('1118CP', '202');

        $this->assertSame('http://api.postcodedata.nl/v1/postcode/?postcode=1118CP&streetnumber=202&ref=localhost', (string)$this->httpClient->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

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
        $_SERVER['HTTP_HOST'] = 'localhost';

        $this->httpClient->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"status":"error","errormessage":"no results"}')
            ]),
        ]));

        $address = $this->postcodeData->findByPostcodeAndHouseNumber('9999CP', '202');

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
