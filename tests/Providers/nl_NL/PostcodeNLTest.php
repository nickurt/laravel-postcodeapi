<?php

namespace nickurt\PostcodeApi\tests\Providers\nl_NL;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use nickurt\PostcodeApi\Exception\NotSupportedException;
use nickurt\PostcodeApi\Providers\nl_NL\PostcodeNL;
use nickurt\PostcodeApi\tests\Providers\BaseProviderTest;

class PostcodeNLTest extends BaseProviderTest
{
    /** @var \nickurt\postcodeapi\Providers\nl_NL\PostcodeNL */
    protected $postcodeNL;

    public function setUp(): void
    {
        $this->postcodeNL = (new PostcodeNL);
    }

    /** @test */
    public function it_can_get_the_default_config_values_for_this_provider()
    {
        $this->assertSame(null, $this->postcodeNL->getApiKey());
        $this->assertSame('https://api.postcode.nl/rest/addresses/%s/%s', $this->postcodeNL->getRequestUrl());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        $this->expectException(NotSupportedException::class);

        $this->postcodeNL->find('1118CP');
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_a_valid_postal_code()
    {
        $address = $this->postcodeNL->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"street":"Julianastraat","streetNen":"Julianastraat","houseNumber":30,"houseNumberAddition":"","postcode":"2012ES","city":"Haarlem","cityShort":"Haarlem","municipality":"Haarlem","municipalityShort":"Haarlem","province":"Noord-Holland","rdX":103242,"rdY":487716,"latitude":52.37487801,"longitude":4.62714526,"bagNumberDesignationId":"0392200000029398","bagAddressableObjectId":"0392010000029398","addressType":"building","purposes":["office"],"surfaceArea":643,"houseNumberAdditions":[""]}')
            ]),
        ]))->findByPostcodeAndHouseNumber('2012ES', '30');

        $this->assertSame('https://api.postcode.eu/nl/v1/addresses/postcode/2012ES/30', (string)$this->postcodeNL->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertSame([
            'street' => 'Julianastraat',
            'house_no' => '30',
            'town' => 'Haarlem',
            'municipality' => 'Haarlem',
            'province' => 'Noord-Holland',
            'latitude' => 52.37487801,
            'longitude' => 4.62714526
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_an_invalid_postal_code()
    {
        $this->markTestSkipped('Todo');
    }
}
