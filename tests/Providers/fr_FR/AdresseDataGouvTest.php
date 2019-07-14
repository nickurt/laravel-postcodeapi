<?php

namespace nickurt\PostcodeApi\tests\Providers\fr_FR;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\tests\TestCase;
use PostcodeApi;

class AdresseDataGouvTest extends TestCase
{
    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        $postcodeApi = PostcodeApi::create('AddresseDataGouv')->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"type": "FeatureCollection", "version": "draft", "features": [{"type": "Feature", "geometry": {"type": "Point", "coordinates": [2.315207, 48.860861]}, "properties": {"label": "Rue de l\'Universit\u00e9 75007 Paris", "score": 0.6781636363636363, "citycode": "75107", "context": "75, Paris, \u00cele-de-France", "postcode": "75007", "name": "Rue de l\'Universit\u00e9", "id": "75107_XXXX_9c6a85", "y": 6862531.9, "importance": 0.4598, "type": "street", "city": "Paris", "x": 649758.9}}], "attribution": "BAN", "licence": "ODbL 1.0", "query": "75007", "limit": 1}')
            ]),
        ]))->find('75007');

        $this->assertInstanceOf(Address::class, $postcodeApi);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Paris',
            'municipality' => null,
            'province' => null,
            'latitude' => 48.860861,
            'longitude' => 2.315207
        ], $postcodeApi->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_an_invalid_postal_code()
    {
        $this->markTestSkipped('Todo');
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_a_valid_postal_code()
    {
        $postcodeApi = PostcodeApi::create('AddresseDataGouv')->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"type": "FeatureCollection", "version": "draft", "features": [{"type": "Feature", "geometry": {"type": "Point", "coordinates": [2.328123, 48.859831]}, "properties": {"label": "5 Quai Anatole France 75007 Paris", "score": 0.4796818181818181, "housenumber": "5", "citycode": "75107", "context": "75, Paris, \u00cele-de-France", "postcode": "75007", "name": "5 Quai Anatole France", "id": "ADRNIVX_0000000270768224", "y": 6862409.3, "importance": 0.2765, "type": "housenumber", "city": "Paris", "x": 650705.5, "street": "Quai Anatole France"}}], "attribution": "BAN", "licence": "ODbL 1.0", "query": "5 Avenue Anatole France", "filters": {"postcode": "75007"}, "limit": 1}')
            ]),
        ]))->findByPostcodeAndHouseNumber('75007', '5 Avenue Anatole France');

        $this->assertInstanceOf(Address::class, $postcodeApi);

        $this->assertSame([
            'street' => 'Quai Anatole France',
            'house_no' => '5',
            'town' => 'Paris',
            'municipality' => null,
            'province' => null,
            'latitude' => 48.859831,
            'longitude' => 2.328123
        ], $postcodeApi->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_an_invalid_postal_code()
    {
        $this->markTestSkipped('Todo');
    }
}