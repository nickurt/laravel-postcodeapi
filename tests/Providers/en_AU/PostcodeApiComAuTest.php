<?php

namespace nickurt\PostcodeApi\tests\Providers\en_AU;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\tests\TestCase;
use PostcodeApi;

class PostcodeApiComAuTest extends TestCase
{
    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        $postcodeApi = PostcodeApi::create('PostcodeApiComAu')->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '[{"name": "Collingwood", "postcode": 3066, "state": {"name": "Victoria", "abbreviation": "VIC"}, "locality": "HAWTHORN", "latitude": -37.799999999999997, "longitude": 144.98330000000001}]')
            ]),
        ]))->find('3306');

        $this->assertInstanceOf(Address::class, $postcodeApi);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Collingwood',
            'municipality' => 'Victoria',
            'province' => null,
            'latitude' => -37.8,
            'longitude' => 144.9833
        ], $postcodeApi->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_an_invalid_postal_code()
    {
        $this->markTestSkipped('Todo');
    }
}
