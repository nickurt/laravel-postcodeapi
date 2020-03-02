<?php

namespace nickurt\PostcodeApi\tests\Providers\en_US;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\tests\Providers\BaseProviderTest;

class GraphHopperTest extends BaseProviderTest
{
    /** @var \nickurt\PostcodeApi\Providers\en_US\GraphHopper */
    protected $graphHopper;

    /** @var \nickurt\PostcodeApi\Http\Guzzle6HttpClient */
    protected $httpClient;

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        $this->httpClient->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"hits":[{"osm_id":2995361210,"osm_type":"N","country":"United States of America","osm_key":"waterway","city":"Rancho Mirage","osm_value":"waterfall","postcode":"92270","name":"Rancho Mirage","state":"California","point":{"lng":-116.461294,"lat":33.7642562}}],"took":12}')
            ]),
        ]));

        $address = $this->graphHopper->find('92270');

        $this->assertSame('https://graphhopper.com/api/1/geocode?q=92270&key=9006866e-8eba-4816-9a29-e5866ac98a3a&limit=1', (string)$this->httpClient->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Rancho Mirage',
            'municipality' => null,
            'province' => 'California',
            'latitude' => 33.7642562,
            'longitude' => -116.461294
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code2()
    {
        $this->httpClient->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"hits":[{"osm_id":232148333,"osm_type":"W","extent":[4.7442827,52.305741,4.7461203,52.302845],"country":"The Netherlands","osm_key":"highway","city":"Haarlemmermeer","osm_value":"motorway","postcode":"1118CP","name":"Haarlemmermeer","state":"North Holland","point":{"lng":4.7452654,"lat":52.3043478}}],"took":9}')
            ]),
        ]));

        $address = $this->graphHopper->find('1118CP');

        $this->assertSame('https://graphhopper.com/api/1/geocode?q=1118CP&key=9006866e-8eba-4816-9a29-e5866ac98a3a&limit=1', (string)$this->httpClient->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

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
                new Response(200, [], '{"hits":[{"osm_id":374945234,"osm_type":"W","extent":[-0.1407086,51.5019161,-0.1404644,51.5017637],"country":"United Kingdom","osm_key":"tourism","city":"London","street":"Constitution Hill","osm_value":"attraction","postcode":"SW1A 1AA","name":"Victoria Memorial","state":"England","point":{"lng":-0.14058648979892263,"lat":51.501839950000004}}],"took":11}')
            ]),
        ]));

        $address = $this->graphHopper->find('SW1A 1AA');

        $this->assertSame('https://graphhopper.com/api/1/geocode?q=SW1A%201AA&key=9006866e-8eba-4816-9a29-e5866ac98a3a&limit=1', (string)$this->httpClient->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

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
                new Response(200, [], '{"hits":[{"osm_id":2383182,"osm_type":"R","extent":[144.98255,-37.7938788,144.9937455,-37.8097888],"country":"Australia","osm_key":"place","osm_value":"suburb","postcode":"3066","name":"Collingwood","state":"Victoria","point":{"lng":144.9881387,"lat":-37.802104}}],"took":14}')
            ]),
        ]));

        $address = $this->graphHopper->find('3066');

        $this->assertSame('https://graphhopper.com/api/1/geocode?q=3066&key=9006866e-8eba-4816-9a29-e5866ac98a3a&limit=1', (string)$this->httpClient->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

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
                new Response(200, [], '{"hits":[{"osm_id":248177663,"osm_type":"N","country":"France","osm_key":"place","city":"Paris","osm_value":"suburb","postcode":"75007","name":"7th Arrondissement","state":"Ile-de-France","point":{"lng":2.3201953,"lat":48.8570281}}],"took":8}')
            ]),
        ]));

        $address = $this->graphHopper->find('75007');

        $this->assertSame('https://graphhopper.com/api/1/geocode?q=75007&key=9006866e-8eba-4816-9a29-e5866ac98a3a&limit=1', (string)$this->httpClient->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

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
                new Response(200, [], '{"hits":[{"osm_id":4413902500,"osm_type":"N","country":"Belgium","osm_key":"shop","housenumber":"132-136","city":"Ville de Bruxelles - Stad Brussel","street":"Boulevard Anspach - Anspachlaan","osm_value":"copyshop","postcode":"1000","name":"Belgium Copy","state":"Brussels-Capital","point":{"lng":4.3482287,"lat":50.8466964}}],"took":10}')
            ]),
        ]));

        $address = $this->graphHopper->find('1000');

        $this->assertSame('https://graphhopper.com/api/1/geocode?q=1000&key=9006866e-8eba-4816-9a29-e5866ac98a3a&limit=1', (string)$this->httpClient->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

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
                new Response(200, [], '{"hits":[{"osm_id":2372041834,"osm_type":"N","country":"Germany","osm_key":"office","housenumber":"9a","city":"Berlin","street":"Pflugstraße","osm_value":"political_party","postcode":"10115","name":"Pirate Party Germany / Pirate Party Berlin / Young Pirates","state":"Berlin","point":{"lng":13.3798521,"lat":52.5366336}}],"took":5}')
            ]),
        ]));

        $address = $this->graphHopper->find('10115');

        $this->assertSame('https://graphhopper.com/api/1/geocode?q=10115&key=9006866e-8eba-4816-9a29-e5866ac98a3a&limit=1', (string)$this->httpClient->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Berlin',
            'municipality' => null,
            'province' => 'Berlin',
            'latitude' => 52.5366336,
            'longitude' => 13.3798521
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code8()
    {
        $this->httpClient->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"hits":[{"osm_id":307567824,"osm_type":"W","extent":[16.3656524,48.2116669,16.3657213,48.2116222],"country":"Austria","osm_key":"amenity","city":"Vienna","street":"Freyung","osm_value":"fountain","postcode":"1010","name":"Austriabrunnen","state":"Vienna","point":{"lng":16.365686888324177,"lat":48.2116436}}],"took":12}')
            ]),
        ]));

        $address = $this->graphHopper->find('1010');

        $this->assertSame('https://graphhopper.com/api/1/geocode?q=1010&key=9006866e-8eba-4816-9a29-e5866ac98a3a&limit=1', (string)$this->httpClient->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

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
                new Response(200, [], '{"hits":[],"took":12}')
            ]),
        ]));

        $address = $this->graphHopper->find('zeroresults');

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
                new Response(200, [], '{"hits":[{"osm_id":704701882,"osm_type":"W","extent":[-116.4219321,33.748194,-116.4206799,33.7475341],"country":"United States of America","osm_key":"highway","city":"Rancho Mirage","osm_value":"primary","postcode":"CA 92270","name":"Highway 111","state":"California","point":{"lng":-116.4208697,"lat":33.7476236}}],"took":7}')
            ]),
        ]));

        $address = $this->graphHopper->findByPostcodeAndHouseNumber('92270', 1);

        $this->assertSame('https://graphhopper.com/api/1/geocode?q=92270,1&key=9006866e-8eba-4816-9a29-e5866ac98a3a&limit=1', (string)$this->httpClient->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

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
                new Response(200, [], '{"hits":[{"osm_id":2739765969,"osm_type":"N","country":"The Netherlands","osm_key":"place","housenumber":"202","city":"Haarlemmermeer","street":"Evert van de Beekstraat","osm_value":"house","postcode":"1118CP","name":"Evert van de Beekstraat","state":"North Holland","point":{"lng":4.7479076,"lat":52.3038972}}],"took":8}')
            ]),
        ]));

        $address = $this->graphHopper->findByPostcodeAndHouseNumber('1118CP', 202);

        $this->assertSame('https://graphhopper.com/api/1/geocode?q=1118CP,202&key=9006866e-8eba-4816-9a29-e5866ac98a3a&limit=1', (string)$this->httpClient->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

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
                new Response(200, [], '{"hits":[{"osm_id":1879842,"extent":[-0.1278356,51.5036483,-0.1273038,51.5032573],"country":"United Kingdom","city":"London","postcode":"SW1A 2AA","point":{"lng":-0.12770820958562096,"lat":51.50344025},"osm_type":"R","osm_key":"tourism","housenumber":"10","street":"Downing Street","osm_value":"attraction","name":"Prime Minister\u2019s Office","state":"England"}],"took":11}')
            ]),
        ]));

        $address = $this->graphHopper->findByPostcodeAndHouseNumber('SW1A 2AA', 10);

        $this->assertSame('https://graphhopper.com/api/1/geocode?q=SW1A%202AA,10&key=9006866e-8eba-4816-9a29-e5866ac98a3a&limit=1', (string)$this->httpClient->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

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
        $this->httpClient->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"hits":[{"osm_id":2383182,"osm_type":"R","extent":[144.98255,-37.7938788,144.9937455,-37.8097888],"country":"Australia","osm_key":"place","osm_value":"suburb","postcode":"3066","name":"Collingwood","state":"Victoria","point":{"lng":144.9881387,"lat":-37.802104}}],"took":60}')
            ]),
        ]));

        $address = $this->graphHopper->findByPostcodeAndHouseNumber('3066', 107);

        $this->assertSame('https://graphhopper.com/api/1/geocode?q=3066,107&key=9006866e-8eba-4816-9a29-e5866ac98a3a&limit=1', (string)$this->httpClient->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

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
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_a_valid_postal_code5()
    {
        $this->httpClient->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"hits":[{"osm_id":3904913457,"osm_type":"N","country":"France","osm_key":"amenity","city":"Paris","street":"Rue Duroc","osm_value":"car_sharing","postcode":"75007","name":"Paris/Duroc/2","state":"Ile-de-France","point":{"lng":2.3153959,"lat":48.8481462}}],"took":17}')
            ]),
        ]));

        $address = $this->graphHopper->findByPostcodeAndHouseNumber('75007', 2);

        $this->assertSame('https://graphhopper.com/api/1/geocode?q=75007,2&key=9006866e-8eba-4816-9a29-e5866ac98a3a&limit=1', (string)$this->httpClient->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

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
                new Response(200, [], '{"hits":[{"osm_id":6915108665,"osm_type":"N","country":"Belgium","osm_key":"amenity","housenumber":"6","city":"Ville de Bruxelles - Stad Brussel","street":"Boulevard Anspach - Anspachlaan","osm_value":"photo_booth","postcode":"1000","name":"Boulevard Anspach - Anspachlaan","state":"Brussels-Capital","point":{"lng":4.3524321,"lat":50.8505039}}],"took":14}')
            ]),
        ]));

        $address = $this->graphHopper->findByPostcodeAndHouseNumber('1000', 6);

        $this->assertSame('https://graphhopper.com/api/1/geocode?q=1000,6&key=9006866e-8eba-4816-9a29-e5866ac98a3a&limit=1', (string)$this->httpClient->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => 'Boulevard Anspach - Anspachlaan',
            'house_no' => '6',
            'town' => 'Ville de Bruxelles - Stad Brussel',
            'municipality' => null,
            'province' => 'Brussels-Capital',
            'latitude' => 50.8505039,
            'longitude' => 4.3524321
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_a_valid_postal_code7()
    {
        $this->httpClient->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"hits":[{"osm_id":4597206,"osm_type":"W","extent":[13.3887994,52.530697,13.3913963,52.5280319],"country":"Germany","osm_key":"highway","city":"Berlin","osm_value":"residential","postcode":"10115","name":"Borsigstraße","state":"Berlin","point":{"lng":13.3895587,"lat":52.5297465}}],"took":11}')
            ]),
        ]));

        $address = $this->graphHopper->findByPostcodeAndHouseNumber('10115', 1);

        $this->assertSame('https://graphhopper.com/api/1/geocode?q=10115,1&key=9006866e-8eba-4816-9a29-e5866ac98a3a&limit=1', (string)$this->httpClient->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Berlin',
            'municipality' => null,
            'province' => 'Berlin',
            'latitude' => 52.5297465,
            'longitude' => 13.3895587
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_a_valid_postal_code8()
    {
        $this->httpClient->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"hits":[{"osm_id":3189033579,"osm_type":"N","country":"Austria","osm_key":"tourism","housenumber":"2","city":"Vienna","street":"Am Hof","osm_value":"hotel","postcode":"1010","name":"Park Hyatt Vienna","state":"Vienna","point":{"lng":16.3679689,"lat":48.210653}}],"took":15}')
            ]),
        ]));

        $address = $this->graphHopper->findByPostcodeAndHouseNumber('1010', 2);

        $this->assertSame('https://graphhopper.com/api/1/geocode?q=1010,2&key=9006866e-8eba-4816-9a29-e5866ac98a3a&limit=1', (string)$this->httpClient->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => 'Am Hof',
            'house_no' => '2',
            'town' => 'Vienna',
            'municipality' => null,
            'province' => 'Vienna',
            'latitude' => 48.210653,
            'longitude' => 16.3679689
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_an_invalid_postal_code()
    {
        $this->httpClient->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"hits":[],"took":14}')
            ]),
        ]));

        $address = $this->graphHopper->findByPostcodeAndHouseNumber('zeroresults', 'zeroresults');

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
    public function it_can_get_the_default_config_values_for_this_provider()
    {
        $this->assertSame('9006866e-8eba-4816-9a29-e5866ac98a3a', $this->graphHopper->getApiKey());
        $this->assertSame('https://graphhopper.com/api/1/geocode', $this->graphHopper->getRequestUrl());
    }

    public function setUp(): void
    {
        $this->graphHopper = (new \nickurt\PostcodeApi\Providers\en_US\GraphHopper(
            $this->httpClient = new \nickurt\PostcodeApi\Http\Guzzle6HttpClient()
        ))->setApiKey('9006866e-8eba-4816-9a29-e5866ac98a3a');
    }
}
