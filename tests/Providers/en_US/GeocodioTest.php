<?php

namespace nickurt\PostcodeApi\tests\Providers\en_US;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\tests\TestCase;
use PostcodeApi;

class GeocodioTest extends TestCase
{
    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        $postcodeApi = PostcodeApi::create('Geocodio')->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"input":{"address_components":{"number":"42370","street":"Bob Hope","suffix":"Dr","formatted_street":"Bob Hope Dr","city":"Rancho Mirage","state":"CA","country":"US"},"formatted_address":"42370 Bob Hope Dr, Rancho Mirage, CA"},"results":[{"address_components":{"number":"42370","street":"Bob Hope","suffix":"Dr","formatted_street":"Bob Hope Dr","city":"Rancho Mirage","county":"Riverside County","state":"CA","zip":"92270","country":"US"},"formatted_address":"42370 Bob Hope Dr, Rancho Mirage, CA 92270","location":{"lat":33.73865,"lng":-116.407153},"accuracy":1,"accuracy_type":"rooftop","source":"Riverside"}]}')
            ]),
        ]))->find('42370+Bob+Hope+Drive,+Rancho+Mirage+CA');

        $this->assertInstanceOf(Address::class, $postcodeApi);

        $this->assertSame([
            'street' => 'Bob Hope Dr',
            'house_no' => null,
            'town' => 'Rancho Mirage',
            'municipality' => 'CA',
            'province' => null,
            'latitude' => 33.73865,
            'longitude' => -116.407153
        ], $postcodeApi->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_an_invalid_postal_code()
    {
        $this->markTestSkipped('Todo');
    }
}