<?php

namespace nickurt\PostcodeApi\tests\Providers\nl_NL;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\tests\TestCase;
use PostcodeApi;

class Pro6PP_NLTest extends TestCase
{
    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        $postcodeApi = PostcodeApi::create('Pro6PP_NL')->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"status":"ok","results":[{"nl_sixpp":"1118CP","street":"Evert van de Beekstraat","city":"Schiphol","municipality":"Haarlemmermeer","province":"Noord-Holland","streetnumbers":"178;202;300-306","lat":52.30389,"lng":4.7479,"areacode":"020"}]}')
            ]),
        ]))->find('1000');

        $this->assertInstanceOf(Address::class, $postcodeApi);

        $this->assertSame([
            'street' => 'Evert van de Beekstraat',
            'house_no' => null,
            'town' => 'Schiphol',
            'municipality' => 'Haarlemmermeer',
            'province' => 'Noord-Holland',
            'latitude' => 52.30389,
            'longitude' => 4.7479
        ], $postcodeApi->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_an_invalid_postal_code()
    {
        $this->markTestSkipped('Todo');
    }
}