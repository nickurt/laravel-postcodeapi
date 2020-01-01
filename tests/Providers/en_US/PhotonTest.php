<?php

namespace nickurt\PostcodeApi\tests\Providers\en_US;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\en_US\Photon;
use nickurt\PostcodeApi\tests\Providers\BaseProviderTest;

class PhotonTest extends BaseProviderTest
{
    /** @var Photon */
    protected $photon;

    /** @var \nickurt\PostcodeApi\Http\Guzzle6HttpClient */
    protected $httpClient;

    public function setUp(): void
    {
        $this->photon = (new Photon($this->httpClient = new \nickurt\PostcodeApi\Http\Guzzle6HttpClient()));
    }

    /** @test */
    public function it_can_get_the_default_config_values_for_this_provider()
    {
        $this->assertSame('https://photon.komoot.de', $this->photon->getRequestUrl());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        $this->httpClient->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"features":[{"geometry":{"coordinates":[-116.42687402345575,33.770859],"type":"Point"},"type":"Feature","properties":{"osm_id":2866319,"osm_type":"R","extent":[-116.4777316,33.8269354,-116.3881501,33.7140741],"country":"United States of America","osm_key":"place","city":"Rancho Mirage","street":"Cromwell Court","osm_value":"town","postcode":"CA 92270","name":"Rancho Mirage","state":"California"}}],"type":"FeatureCollection"}')
            ]),
        ]));

        $address = $this->photon->find('92270');

        $this->assertSame('https://photon.komoot.de/api/?q=92270&limit=1', (string)$this->httpClient->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Rancho Mirage',
            'municipality' => null,
            'province' => 'California',
            'latitude' => 33.770859,
            'longitude' => -116.42687402345575
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code2()
    {
        $this->httpClient->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"features":[{"geometry":{"coordinates":[4.7452654,52.3043478],"type":"Point"},"type":"Feature","properties":{"osm_id":232148333,"osm_type":"W","extent":[4.7442827,52.305741,4.7461203,52.302845],"country":"The Netherlands","osm_key":"highway","city":"Haarlemmermeer","osm_value":"motorway","postcode":"1118CP","state":"North Holland"}}],"type":"FeatureCollection"}')
            ]),
        ]));

        $address = $this->photon->find('1118CP');

        $this->assertSame('https://photon.komoot.de/api/?q=1118CP&limit=1', (string)$this->httpClient->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Haarlemmermeer',
            'municipality' => null,
            'province' => 'North Holland',
            'latitude' => 52.3043478,
            'longitude' => 4.7452654
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code3()
    {
        $this->httpClient->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"features":[{"geometry":{"coordinates":[-0.14058648979892263,51.501839950000004],"type":"Point"},"type":"Feature","properties":{"osm_id":374945234,"osm_type":"W","extent":[-0.1407086,51.5019161,-0.1404644,51.5017637],"country":"United Kingdom","osm_key":"tourism","city":"London","street":"Constitution Hill","osm_value":"attraction","postcode":"SW1A 1AA","name":"Victoria Memorial","state":"England"}}],"type":"FeatureCollection"}')
            ]),
        ]));

        $address = $this->photon->find('SW1A 1AA');

        $this->assertSame('https://photon.komoot.de/api/?q=SW1A%201AA&limit=1', (string)$this->httpClient->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'London',
            'municipality' => null,
            'province' => 'England',
            'latitude' => 51.501839950000004,
            'longitude' => -0.14058648979892263
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code4()
    {
        $this->httpClient->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"features":[{"geometry":{"coordinates":[144.9881387,-37.802104],"type":"Point"},"type":"Feature","properties":{"osm_id":2383182,"osm_type":"R","extent":[144.98255,-37.7938788,144.9937455,-37.8097888],"country":"Australia","osm_key":"place","osm_value":"suburb","postcode":"3066","name":"Collingwood","state":"Victoria"}}],"type":"FeatureCollection"}')
            ]),
        ]));

        $address = $this->photon->find('3066');

        $this->assertSame('https://photon.komoot.de/api/?q=3066&limit=1', (string)$this->httpClient->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Collingwood',
            'municipality' => null,
            'province' => 'Victoria',
            'latitude' => -37.802104,
            'longitude' => 144.9881387
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code5()
    {
        $this->httpClient->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"features":[{"geometry":{"coordinates":[2.3201953,48.8570281],"type":"Point"},"type":"Feature","properties":{"osm_id":248177663,"osm_type":"N","country":"France","osm_key":"place","city":"Paris","osm_value":"suburb","postcode":"75007","name":"7th Arrondissement","state":"Ile-de-France"}}],"type":"FeatureCollection"}')
            ]),
        ]));

        $address = $this->photon->find('75007');

        $this->assertSame('https://photon.komoot.de/api/?q=75007&limit=1', (string)$this->httpClient->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Paris',
            'municipality' => null,
            'province' => 'Ile-de-France',
            'latitude' => 48.8570281,
            'longitude' => 2.3201953
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code6()
    {
        $this->httpClient->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"features":[{"geometry":{"coordinates":[4.3482287,50.8466964],"type":"Point"},"type":"Feature","properties":{"osm_id":4413902500,"osm_type":"N","country":"Belgium","osm_key":"shop","housenumber":"132-136","city":"Ville de Bruxelles - Stad Brussel","street":"Boulevard Anspach - Anspachlaan","osm_value":"copyshop","postcode":"1000","name":"Belgium Copy","state":"Brussels-Capital"}}],"type":"FeatureCollection"}')
            ]),
        ]));

        $address = $this->photon->find('1000');

        $this->assertSame('https://photon.komoot.de/api/?q=1000&limit=1', (string)$this->httpClient->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Ville de Bruxelles - Stad Brussel',
            'municipality' => null,
            'province' => 'Brussels-Capital',
            'latitude' => 50.8466964,
            'longitude' => 4.3482287
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code7()
    {
        $this->httpClient->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"features":[{"geometry":{"coordinates":[10.4234469,51.0834196],"type":"Point"},"type":"Feature","properties":{"osm_id":51477,"osm_type":"R","extent":[5.8663153,55.099161,15.0419319,47.2701114],"country":"Germany","osm_key":"place","osm_value":"country","name":"Germany"}}],"type":"FeatureCollection"}')
            ]),
        ]));

        $address = $this->photon->find('10115');

        $this->assertSame('https://photon.komoot.de/api/?q=10115&limit=1', (string)$this->httpClient->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Germany',
            'municipality' => null,
            'province' => null,
            'latitude' => 51.0834196,
            'longitude' => 10.4234469
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code8()
    {
        $this->httpClient->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"features":[{"geometry":{"coordinates":[16.365686888324177,48.2116436],"type":"Point"},"type":"Feature","properties":{"osm_id":307567824,"osm_type":"W","extent":[16.3656524,48.2116669,16.3657213,48.2116222],"country":"Austria","osm_key":"amenity","city":"Vienna","street":"Freyung","osm_value":"fountain","postcode":"1010","name":"Austriabrunnen","state":"Vienna"}}],"type":"FeatureCollection"}')
            ]),
        ]));

        $address = $this->photon->find('1010');

        $this->assertSame('https://photon.komoot.de/api/?q=1010&limit=1', (string)$this->httpClient->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Vienna',
            'municipality' => null,
            'province' => 'Vienna',
            'latitude' => 48.2116436,
            'longitude' => 16.365686888324177
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_an_invalid_postal_code()
    {
        $this->httpClient->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"features":[],"type":"FeatureCollection"}')
            ]),
        ]));

        $address = $this->photon->find('zeroresults');

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
        $this->httpClient->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"features":[{"geometry":{"coordinates":[-116.4208697,33.7476236],"type":"Point"},"type":"Feature","properties":{"osm_id":704701882,"osm_type":"W","extent":[-116.4219321,33.748194,-116.4206799,33.7475341],"country":"United States of America","osm_key":"highway","city":"Rancho Mirage","osm_value":"primary","postcode":"CA 92270","name":"Highway 111","state":"California"}}],"type":"FeatureCollection"}')
            ]),
        ]));

        $address = $this->photon->findByPostcodeAndHouseNumber('92270', 1);

        $this->assertSame('https://photon.komoot.de/api/?q=92270,1&limit=1', (string)$this->httpClient->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Rancho Mirage',
            'municipality' => null,
            'province' => 'California',
            'latitude' => 33.7476236,
            'longitude' => -116.4208697
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_a_valid_postal_code2()
    {
        $this->httpClient->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"features":[{"geometry":{"coordinates":[4.7479076,52.3038972],"type":"Point"},"type":"Feature","properties":{"osm_id":2739765969,"osm_type":"N","country":"The Netherlands","osm_key":"place","housenumber":"202","city":"Haarlemmermeer","street":"Evert van de Beekstraat","osm_value":"house","postcode":"1118CP","state":"North Holland"}}],"type":"FeatureCollection"}')
            ]),
        ]));

        $address = $this->photon->findByPostcodeAndHouseNumber('1118CP', 202);

        $this->assertSame('https://photon.komoot.de/api/?q=1118CP,202&limit=1', (string)$this->httpClient->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => 'Evert van de Beekstraat',
            'house_no' => '202',
            'town' => 'Haarlemmermeer',
            'municipality' => null,
            'province' => 'North Holland',
            'latitude' => 52.3038972,
            'longitude' => 4.7479076
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_a_valid_postal_code3()
    {
        $this->httpClient->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"features":[{"geometry":{"coordinates":[-0.12770820958562096,51.50344025],"type":"Point"},"type":"Feature","properties":{"osm_id":1879842,"osm_type":"R","extent":[-0.1278356,51.5036483,-0.1273038,51.5032573],"country":"United Kingdom","osm_key":"tourism","housenumber":"10","city":"London","street":"Downing Street","osm_value":"attraction","postcode":"SW1A 2AA","name":"Prime Minister\u2019s Office","state":"England"}}],"type":"FeatureCollection"}')
            ]),
        ]));

        $address = $this->photon->findByPostcodeAndHouseNumber('SW1A 2AA', 10);

        $this->assertSame('https://photon.komoot.de/api/?q=SW1A%202AA,10&limit=1', (string)$this->httpClient->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => 'Downing Street',
            'house_no' => '10',
            'town' => 'London',
            'municipality' => null,
            'province' => 'England',
            'latitude' => 51.50344025,
            'longitude' => -0.12770820958562096
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_a_valid_postal_code4()
    {
        $this->markTestSkipped('Todo');
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_a_valid_postal_code5()
    {
        $this->httpClient->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"features":[{"geometry":{"coordinates":[2.3153959,48.8481462],"type":"Point"},"type":"Feature","properties":{"osm_id":3904913457,"osm_type":"N","country":"France","osm_key":"amenity","city":"Paris","street":"Rue Duroc","osm_value":"car_sharing","postcode":"75007","name":"Paris/Duroc/2","state":"Ile-de-France"}}],"type":"FeatureCollection"}')
            ]),
        ]));

        $address = $this->photon->findByPostcodeAndHouseNumber('75007', 2);

        $this->assertSame('https://photon.komoot.de/api/?q=75007,2&limit=1', (string)$this->httpClient->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => 'Rue Duroc',
            'house_no' => null,
            'town' => 'Paris',
            'municipality' => null,
            'province' => 'Ile-de-France',
            'latitude' => 48.8481462,
            'longitude' => 2.3153959
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_a_valid_postal_code6()
    {
        $this->httpClient->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"features":[{"geometry":{"coordinates":[4.352739504086289,50.8502776],"type":"Point"},"type":"Feature","properties":{"osm_id":74034262,"osm_type":"W","extent":[4.3520005,50.8507621,4.353511,50.8497501],"country":"Belgium","osm_key":"building","housenumber":"6","city":"Ville de Bruxelles - Stad Brussel","street":"Boulevard Anspach - Anspachlaan","osm_value":"office","postcode":"1000","name":"Centre administratif ville de Bruxelles - Administratief centrum stad Brussel","state":"Brussels-Capital"}}],"type":"FeatureCollection"}')
            ]),
        ]));

        $address = $this->photon->findByPostcodeAndHouseNumber('1000', 6);

        $this->assertSame('https://photon.komoot.de/api/?q=1000,6&limit=1', (string)$this->httpClient->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => 'Boulevard Anspach - Anspachlaan',
            'house_no' => '6',
            'town' => 'Ville de Bruxelles - Stad Brussel',
            'municipality' => null,
            'province' => 'Brussels-Capital',
            'latitude' => 50.8502776,
            'longitude' => 4.352739504086289
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_a_valid_postal_code7()
    {
        $this->markTestSkipped('Todo');
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_a_valid_postal_code8()
    {
        $this->httpClient->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"features":[{"geometry":{"coordinates":[16.3736933,48.2128719],"type":"Point"},"type":"Feature","properties":{"osm_id":334637049,"osm_type":"N","country":"Austria","osm_key":"shop","housenumber":"2","city":"Vienna","street":"Salzgries","osm_value":"furniture","postcode":"1010","name":"Bretz Austria","state":"Vienna"}}],"type":"FeatureCollection"}')
            ]),
        ]));

        $address = $this->photon->findByPostcodeAndHouseNumber('1010', 2);

        $this->assertSame('https://photon.komoot.de/api/?q=1010,2&limit=1', (string)$this->httpClient->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => 'Salzgries',
            'house_no' => '2',
            'town' => 'Vienna',
            'municipality' => null,
            'province' => 'Vienna',
            'latitude' => 48.2128719,
            'longitude' => 16.3736933
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_an_invalid_postal_code()
    {
        $this->httpClient->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"features":[],"type":"FeatureCollection"}')
            ]),
        ]));

        $address = $this->photon->findByPostcodeAndHouseNumber('zeroresults', 'zeroresults');

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
