<?php

namespace nickurt\PostcodeApi\tests\Providers\nl_BE;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\tests\TestCase;
use PostcodeApi;

class Pro6PP_BETest extends TestCase
{
    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        $postcodeApi = PostcodeApi::create('Pro6PP_BE')->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"status":"ok","results":[{"province_nl":"Brussel","province_fr":"Brussel","province":"Brussel","municipality_nl":"Brussel","municipality_fr":"Brussel","municipality":"Brussel","city_nl":"Brussel","city_fr":"Bruxelles","city":"Brussel","fourpp":1000,"lat":50.84515,"lng":4.35842}]}')
            ]),
        ]))->find('1000');

        $this->assertInstanceOf(Address::class, $postcodeApi);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Brussel',
            'municipality' => 'Brussel',
            'province' => 'Brussel',
            'latitude' => 50.84515,
            'longitude' => 4.35842
        ], $postcodeApi->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_an_invalid_postal_code()
    {
        $this->markTestSkipped('Todo');
    }
}
