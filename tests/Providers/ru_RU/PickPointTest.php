<?php

namespace nickurt\PostcodeApi\tests\Providers\ru_RU;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Exceptions\NotSupportedException;
use nickurt\PostcodeApi\tests\Providers\BaseProviderTest;

class PickPointTest extends BaseProviderTest
{
    /** @var \nickurt\PostcodeApi\Http\Guzzle6HttpClient */
    protected $httpClient;

    /** @var \nickurt\PostcodeApi\Providers\ru_RU\PickPoint */
    protected $pickPoint;

    public function setUp(): void
    {
        $this->pickPoint = (new \nickurt\PostcodeApi\Providers\ru_RU\PickPoint($this->httpClient = new \nickurt\PostcodeApi\Http\Guzzle6HttpClient()))
            ->setApiKey('w22UfusOrmZC7Pcrdvtz');
    }

    /** @test */
    public function it_can_get_the_default_config_values_for_this_provider()
    {
        $this->assertSame('https://api.pickpoint.io/v1/forward', $this->pickPoint->getRequestUrl());
        $this->assertSame('w22UfusOrmZC7Pcrdvtz', $this->pickPoint->getApiKey());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        $this->httpClient->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '[{"place_id":"240620856","licence":"Data © OpenStreetMap contributors, ODbL 1.0. https:\/\/osm.org\/copyright","boundingbox":["33.766469637222","33.766569637222","-116.4514329067","-116.4513329067"],"lat":"33.7665196372222","lon":"-116.451382906695","display_name":"Rancho Mirage, California, 92270, USA","class":"place","type":"postcode","importance":0.335,"address":{"city":"Rancho Mirage","state":"California","postcode":"92270","country":"USA","country_code":"us"}}]')
            ]),
        ]));

        $address = $this->pickPoint->setOptions(['countrycodes' => 'us'])->find('92270');

        $this->assertSame('https://api.pickpoint.io/v1/forward?q=92270&format=json&addressdetails=1&limit=1&key=w22UfusOrmZC7Pcrdvtz&countrycodes=us', (string)$this->httpClient->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Rancho Mirage',
            'municipality' => null,
            'province' => 'California',
            'latitude' => 33.7665196372222,
            'longitude' => -116.451382906695
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code2()
    {
        $this->httpClient->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '[{"place_id":"240256062","licence":"Data © OpenStreetMap contributors, ODbL 1.0. https:\/\/osm.org\/copyright","boundingbox":["52.303491683333","52.303591683333","4.7473538166667","4.7474538166667"],"lat":"52.3035416833333","lon":"4.74740381666667","display_name":"Schiphol, Noord-Holland, Nederland, 1118CP, Nederland","class":"place","type":"postcode","importance":0.335,"address":{"suburb":"Schiphol","state":"Noord-Holland","postcode":"1118CP","country":"Nederland","country_code":"nl"}}]')
            ]),
        ]));

        $address = $this->pickPoint->setOptions(['countrycodes' => 'nl'])->find('1118CP');

        $this->assertSame('https://api.pickpoint.io/v1/forward?q=1118CP&format=json&addressdetails=1&limit=1&key=w22UfusOrmZC7Pcrdvtz&countrycodes=nl', (string)$this->httpClient->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Schiphol',
            'municipality' => null,
            'province' => 'Noord-Holland',
            'latitude' => 52.3035416833333,
            'longitude' => 4.74740381666667
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code3()
    {
        $this->httpClient->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '[{"place_id":"239613970","licence":"Data © OpenStreetMap contributors, ODbL 1.0. https:\/\/osm.org\/copyright","boundingbox":["51.50095893648","51.50105893648","-0.14163760012261","-0.14153760012261"],"lat":"51.5010089364798","lon":"-0.141587600122614","display_name":"City of Westminster, SW1A 1AA, UK","class":"place","type":"postcode","importance":0.325,"address":{"city":"City of Westminster","postcode":"SW1A 1AA","country":"UK","country_code":"gb"}}]')
            ]),
        ]));

        $address = $this->pickPoint->find('SW1A 1AA');

        $this->assertSame('https://api.pickpoint.io/v1/forward?q=SW1A%201AA&format=json&addressdetails=1&limit=1&key=w22UfusOrmZC7Pcrdvtz', (string)$this->httpClient->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'City of Westminster',
            'municipality' => null,
            'province' => null,
            'latitude' => 51.5010089364798,
            'longitude' => -0.141587600122614
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code4()
    {
        $this->httpClient->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '[{"place_id":"238158806","licence":"Data © OpenStreetMap contributors, ODbL 1.0. https:\/\/osm.org\/copyright","boundingbox":["-37.802460551054","-37.802360551054","144.9865755488","144.9866755488"],"lat":"-37.8024105510539","lon":"144.986625548797","display_name":"Collingwood, Victoria, 3066, Australia","class":"place","type":"postcode","importance":0.335,"address":{"suburb":"Collingwood","state":"Victoria","postcode":"3066","country":"Australia","country_code":"au"}}]')
            ]),
        ]));

        $address = $this->pickPoint->setOptions(['countrycodes' => 'au'])->find('3066');

        $this->assertSame('https://api.pickpoint.io/v1/forward?q=3066&format=json&addressdetails=1&limit=1&key=w22UfusOrmZC7Pcrdvtz&countrycodes=au', (string)$this->httpClient->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Collingwood',
            'municipality' => null,
            'province' => 'Victoria',
            'latitude' => -37.8024105510539,
            'longitude' => 144.986625548797
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code5()
    {
        $this->httpClient->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '[{"place_id":"245068923","licence":"Data © OpenStreetMap contributors, ODbL 1.0. https:\/\/osm.org\/copyright","osm_type":"relation","osm_id":"10776960","boundingbox":["48.8459336","48.8637782","2.2898239","2.3332665"],"lat":"48.85491365","lon":"2.31285973972637","display_name":"Invalides, 7e, Paris, Île-de-France, France métropolitaine, 75007, France","class":"place","type":"postcode","importance":0.335,"address":{"suburb":"Invalides","city_district":"7e","city":"Paris","county":"Paris","state":"Île-de-France","country":"France","postcode":"75007","country_code":"fr"}}]')
            ]),
        ]));

        $address = $this->pickPoint->setOptions(['countrycodes' => 'fr'])->find('75007');

        $this->assertSame('https://api.pickpoint.io/v1/forward?q=75007&format=json&addressdetails=1&limit=1&key=w22UfusOrmZC7Pcrdvtz&countrycodes=fr', (string)$this->httpClient->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Paris',
            'municipality' => null,
            'province' => 'Île-de-France',
            'latitude' => 48.85491365,
            'longitude' => 2.31285973972637
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code6()
    {
        $this->httpClient->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '[{"place_id":"177305942","licence":"Data © OpenStreetMap contributors, ODbL 1.0. https:\/\/osm.org\/copyright","osm_type":"way","osm_id":"396533093","boundingbox":["50.8450652","50.8459437","4.3679111","4.3696763"],"lat":"50.84549315","lon":"4.36894195312682","display_name":"BXL, Ville de Bruxelles - Stad Brussel, Brussel-Hoofdstad - Bruxelles-Capitale, Région de Bruxelles-Capitale - Brussels Hoofdstedelijk Gewest, 1000, België \/ Belgique \/ Belgien","class":"place","type":"postcode","importance":0.4570698843996,"address":{"city_district":"BXL","city":"Ville de Bruxelles - Stad Brussel","county":"Brussel-Hoofdstad - Bruxelles-Capitale","state":"Région de Bruxelles-Capitale - Brussels Hoofdstedelijk Gewest","postcode":"1000","country":"België \/ Belgique \/ Belgien","country_code":"be"}}]')
            ]),
        ]));

        $address = $this->pickPoint->setOptions(['countrycodes' => 'be'])->find('1000');

        $this->assertSame('https://api.pickpoint.io/v1/forward?q=1000&format=json&addressdetails=1&limit=1&key=w22UfusOrmZC7Pcrdvtz&countrycodes=be', (string)$this->httpClient->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Ville de Bruxelles - Stad Brussel',
            'municipality' => null,
            'province' => 'Région de Bruxelles-Capitale - Brussels Hoofdstedelijk Gewest',
            'latitude' => 50.84549315,
            'longitude' => 4.36894195312682
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code7()
    {
        $this->httpClient->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '[{"place_id":"236182540","licence":"Data © OpenStreetMap contributors, ODbL 1.0. https:\/\/osm.org\/copyright","osm_type":"relation","osm_id":"1402156","boundingbox":["52.5237433","52.5401484","13.3658603","13.4012965"],"lat":"52.53195385","lon":"13.3838001271759","display_name":"Mitte, Berlin, 10115, Deutschland","class":"place","type":"postcode","importance":0.335,"address":{"suburb":"Mitte","city_district":"Mitte","city":"Berlin","state":"Berlin","postcode":"10115","country":"Deutschland","country_code":"de"}}]')
            ]),
        ]));

        $address = $this->pickPoint->setOptions(['countrycodes' => 'de'])->find('10115');

        $this->assertSame('https://api.pickpoint.io/v1/forward?q=10115&format=json&addressdetails=1&limit=1&key=w22UfusOrmZC7Pcrdvtz&countrycodes=de', (string)$this->httpClient->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Berlin',
            'municipality' => null,
            'province' => 'Berlin',
            'latitude' => 52.53195385,
            'longitude' => 13.3838001271759
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code8()
    {
        $this->httpClient->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '[{"place_id":"239298167","licence":"Data © OpenStreetMap contributors, ODbL 1.0. https:\/\/osm.org\/copyright","osm_type":"relation","osm_id":"7917275","boundingbox":["48.1995278","48.2184891","16.3552089","16.3848946"],"lat":"48.2090229","lon":"16.3698511256966","display_name":"KG Innere Stadt, Innere Stadt, Wien, 1010, Österreich","class":"place","type":"postcode","importance":0.335,"address":{"suburb":"KG Innere Stadt","city_district":"Innere Stadt","city":"Wien","state":"Wien","postcode":"1010","country":"Österreich","country_code":"at"}}]')
            ]),
        ]));

        $address = $this->pickPoint->setOptions(['countrycodes' => 'at'])->find('1010');

        $this->assertSame('https://api.pickpoint.io/v1/forward?q=1010&format=json&addressdetails=1&limit=1&key=w22UfusOrmZC7Pcrdvtz&countrycodes=at', (string)$this->httpClient->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Wien',
            'municipality' => null,
            'province' => 'Wien',
            'latitude' => 48.2090229,
            'longitude' => 16.3698511256966
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_an_invalid_postal_code()
    {
        $this->httpClient->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '[]')
            ]),
        ]));

        $address = $this->pickPoint->find('zeroresults');

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
        $this->expectException(NotSupportedException::class);

        $this->pickPoint->findByPostcodeAndHouseNumber('1118CP', '202');
    }
}
