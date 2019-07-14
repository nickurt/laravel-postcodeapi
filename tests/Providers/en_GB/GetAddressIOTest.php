<?php

namespace nickurt\PostcodeApi\tests\Providers\en_GB;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\tests\TestCase;
use PostcodeApi;

class GetAddressIOTest extends TestCase
{
    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        $postcodeApi = PostcodeApi::create('GetAddressIO')->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"latitude":51.503038,"longitude":-0.128371,"addresses":["Prime Minister & First Lord of the Treasury, 10 Downing Street, , , , London, "]}')
            ]),
        ]))->find('SW1A2AA');

        $this->assertInstanceOf(Address::class, $postcodeApi);

        $this->assertSame([
            'street' => 'Prime Minister & First Lord of the Treasury, 10 Downing Street, , , , London, ',
            'house_no' => null,
            'town' => null,
            'municipality' => null,
            'province' => null,
            'latitude' => 51.503038,
            'longitude' => -0.128371
        ], $postcodeApi->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_an_invalid_postal_code()
    {
        $this->markTestSkipped('Todo');
    }
}
