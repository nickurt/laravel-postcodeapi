<?php

namespace nickurt\PostcodeApi\tests\Providers\fr_FR;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\fr_FR\AddresseDataGouv;
use nickurt\PostcodeApi\tests\Providers\BaseProviderTest;

class AdresseDataGouvTest extends BaseProviderTest
{
    /** @var AddresseDataGouv */
    protected $adresseDataGouv;

    public function setUp(): void
    {
        $this->adresseDataGouv = (new AddresseDataGouv);
    }

    /** @test */
    public function it_can_get_the_default_config_values_for_this_provider()
    {
        $this->assertSame('https://api-adresse.data.gouv.fr/search/?q=%s&postcode=%s&limit=1', (string)$this->adresseDataGouv->getRequestUrl());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        $address = $this->adresseDataGouv->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"type": "FeatureCollection", "version": "draft", "features": [{"type": "Feature", "geometry": {"type": "Point", "coordinates": [2.312078, 48.854665]}, "properties": {"label": "Paris 7e Arrondissement", "score": 0.8625920083335853, "id": "75107", "type": "municipality", "name": "Paris 7e Arrondissement", "postcode": "75007", "citycode": "75107", "x": 649523.35, "y": 6861845, "population": 52512, "city": "Paris 7e Arrondissement", "context": "75, Paris, \u00cele-de-France", "importance": 0.4885120916694383}}], "attribution": "BAN", "licence": "ODbL 1.0", "query": "75007", "limit": 1}')
            ]),
        ]))->find('75007');

        $this->assertSame('https://api-adresse.data.gouv.fr/search/?q=75007&postcode=&limit=1', (string)$this->adresseDataGouv->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Paris 7e Arrondissement',
            'municipality' => null,
            'province' => null,
            'latitude' => 48.854665,
            'longitude' => 2.312078
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_an_invalid_postal_code()
    {
        $address = $this->adresseDataGouv->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"type": "FeatureCollection", "version": "draft", "features": [], "attribution": "BAN", "licence": "ODbL 1.0", "query": "175007", "limit": 1}')
            ]),
        ]))->find('175007');

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

    /** @test */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_a_valid_postal_code()
    {
        $address = $this->adresseDataGouv->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"type": "FeatureCollection", "version": "draft", "features": [{"type": "Feature", "geometry": {"type": "Point", "coordinates": [2.294597, 48.858819]}, "properties": {"label": "5 Av Anatole France 75007 Paris", "score": 0.6572976343794834, "housenumber": "5", "id": "75107_0306_00005", "type": "housenumber", "name": "5 Av Anatole France", "postcode": "75007", "citycode": "75107", "x": 648244.83, "y": 6862318.23, "city": "Paris", "district": "Paris 7e Arrondissement", "context": "75, Paris, \u00cele-de-France", "importance": 0.578100065130841, "street": "Av Anatole France"}}], "attribution": "BAN", "licence": "ODbL 1.0", "query": "5 Avenue Anatole France", "filters": {"postcode": "75007"}, "limit": 1}')
            ]),
        ]))->findByPostcodeAndHouseNumber('75007', '5 Avenue Anatole France');

        $this->assertSame('https://api-adresse.data.gouv.fr/search/?q=5+Avenue+Anatole+France&postcode=75007&limit=1', (string)$this->adresseDataGouv->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => 'Av Anatole France',
            'house_no' => '5',
            'town' => 'Paris',
            'municipality' => null,
            'province' => null,
            'latitude' => 48.858819,
            'longitude' => 2.294597
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_an_invalid_postal_code()
    {
        $address = $this->adresseDataGouv->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"type": "FeatureCollection", "version": "draft", "features": [], "attribution": "BAN", "licence": "ODbL 1.0", "query": "5 Avenue Anatole France", "filters": {"postcode": "175007"}, "limit": 1}')
            ]),
        ]))->findByPostcodeAndHouseNumber('175007', '5 Avenue Anatole France');

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
