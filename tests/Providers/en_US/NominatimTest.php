<?php

namespace nickurt\PostcodeApi\tests\Providers\en_US;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Exceptions\NotSupportedException;
use nickurt\PostcodeApi\tests\Providers\BaseProviderTest;

class NominatimTest extends BaseProviderTest
{
    /** @var \nickurt\PostcodeApi\Providers\en_US\Nominatim */
    protected $nominatim;

    public function setUp(): void
    {
        $this->nominatim = (new \nickurt\PostcodeApi\Providers\en_US\Nominatim());
    }

    /** @test */
    public function it_can_get_the_default_config_values_for_this_provider()
    {
        $this->assertSame('https://nominatim.openstreetmap.org/search', $this->nominatim->getRequestUrl());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        $address = $this->nominatim->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '[{"place_id":200405222,"licence":"Data © OpenStreetMap contributors, ODbL 1.0. https://osm.org/copyright","boundingbox":["33.766196892719","33.766296892719","-116.4520731516","-116.4519731516"],"lat":"33.7662468927191","lon":"-116.452023151596","display_name":"Rancho Mirage, Riverside County, Californië, 92270, Verenigde Staten","place_rank":21,"category":"place","type":"postcode","importance":0.335,"address":{"city":"Rancho Mirage","town":"Rancho Mirage","county":"Riverside County","state":"Californië","postcode":"92270","country":"Verenigde Staten","country_code":"us"}}]')
            ]),
        ]))->find('92270');

        $this->assertSame('https://nominatim.openstreetmap.org/search?format=jsonv2&q=92270&addressdetails=1&limit=1', (string)$this->nominatim->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Rancho Mirage',
            'municipality' => 'Riverside County',
            'province' => 'Californië',
            'latitude' => 33.7662468927191,
            'longitude' => -116.452023151596
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code2()
    {
        $address = $this->nominatim->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '[{"place_id":199800903,"licence":"Data © OpenStreetMap contributors, ODbL 1.0. https://osm.org/copyright","boundingbox":["52.303491683333","52.303591683333","4.7473538166667","4.7474538166667"],"lat":"52.3035416833333","lon":"4.74740381666667","display_name":"Schiphol, Haarlemmermeer, Noord-Holland, Nederland, 1118CP, Nederland","place_rank":21,"category":"place","type":"postcode","importance":0.335,"address":{"suburb":"Schiphol","city":"Haarlemmermeer","state":"Noord-Holland","postcode":"1118CP","country":"Nederland","country_code":"nl"}}]')
            ]),
        ]))->find('1118CP');

        $this->assertSame('https://nominatim.openstreetmap.org/search?format=jsonv2&q=1118CP&addressdetails=1&limit=1', (string)$this->nominatim->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Haarlemmermeer',
            'municipality' => 'Schiphol',
            'province' => 'Noord-Holland',
            'latitude' => 52.3035416833333,
            'longitude' => 4.74740381666667
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code3()
    {
        $address = $this->nominatim->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '[{"place_id":201704059,"licence":"Data © OpenStreetMap contributors, ODbL 1.0. https://osm.org/copyright","boundingbox":["51.50095893648","51.50105893648","-0.14163760012261","-0.14153760012261"],"lat":"51.5010089364798","lon":"-0.141587600122614","display_name":"City of Westminster, Londen, Greater London, Engeland, SW1A 1AA, Verenigd Koninkrijk","place_rank":25,"category":"place","type":"postcode","importance":0.325,"address":{"city":"Londen","state_district":"Greater London","state":"Engeland","postcode":"SW1A 1AA","country":"Verenigd Koninkrijk","country_code":"gb"}}]')
            ]),
        ]))->find('SW1A 1AA');

        $this->assertSame('https://nominatim.openstreetmap.org/search?format=jsonv2&q=SW1A%201AA&addressdetails=1&limit=1', (string)$this->nominatim->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Londen',
            'municipality' => 'Greater London',
            'province' => 'Engeland',
            'latitude' => 51.5010089364798,
            'longitude' => -0.141587600122614
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code4()
    {
        $address = $this->nominatim->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '[{"place_id":199426402,"licence":"Data © OpenStreetMap contributors, ODbL 1.0. https://osm.org/copyright","boundingbox":["-37.80246764168","-37.80236764168","144.98656619075","144.98666619075"],"lat":"-37.8024176416802","lon":"144.986616190749","display_name":"Collingwood, City of Yarra, Victoria, 3066, Australië","place_rank":21,"category":"place","type":"postcode","importance":0.335,"address":{"suburb":"Collingwood","county":"City of Yarra","state":"Victoria","postcode":"3066","country":"Australië","country_code":"au"}}]')
            ]),
        ]))->setOptions(['countrycodes' => 'au'])->find('3066');

        $this->assertSame('https://nominatim.openstreetmap.org/search?format=jsonv2&q=3066&addressdetails=1&limit=1&countrycodes=au', (string)$this->nominatim->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Collingwood',
            'municipality' => 'City of Yarra',
            'province' => 'Victoria',
            'latitude' => -37.8024176416802,
            'longitude' => 144.986616190749
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code5()
    {
        $address = $this->nominatim->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '[{"place_id":199543086,"licence":"Data © OpenStreetMap contributors, ODbL 1.0. https://osm.org/copyright","boundingbox":["48.855909629933","48.856009629933","2.3137891064646","2.3138891064646"],"lat":"48.8559596299332","lon":"2.31383910646459","display_name":"Quartier des Invalides, 7th Arrondissement, Parijs, Ile-de-France, Metropolitaans Frankrijk, 75007, Frankrijk","place_rank":21,"category":"place","type":"postcode","importance":0.335,"address":{"suburb":"Quartier des Invalides","city_district":"7th Arrondissement","city":"Parijs","county":"Parijs","state":"Ile-de-France","country":"Frankrijk","postcode":"75007","country_code":"fr"}}]')
            ]),
        ]))->find('75007');

        $this->assertSame('https://nominatim.openstreetmap.org/search?format=jsonv2&q=75007&addressdetails=1&limit=1', (string)$this->nominatim->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Parijs',
            'municipality' => 'Parijs',
            'province' => 'Ile-de-France',
            'latitude' => 48.8559596299332,
            'longitude' => 2.31383910646459
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code6()
    {
        $address = $this->nominatim->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '[{"place_id":163850624,"licence":"Data © OpenStreetMap contributors, ODbL 1.0. https://osm.org/copyright","osm_type":"way","osm_id":396533093,"boundingbox":["50.8450652","50.8459437","4.3679111","4.3696763"],"lat":"50.84549315","lon":"4.36894195312682","display_name":"Brussel, Stad Brussel, Brussel-Hoofdstad, Brussels Hoofdstedelijk Gewest, 1000, België","place_rank":21,"category":"place","type":"postcode","importance":0.46722494608115406,"address":{"city_district":"Brussel","city":"Stad Brussel","county":"Brussel-Hoofdstad","state":"Brussels Hoofdstedelijk Gewest","postcode":"1000","country":"België","country_code":"be"}}]')
            ]),
        ]))->setOptions(['countrycodes' => 'be'])->find('1000');

        $this->assertSame('https://nominatim.openstreetmap.org/search?format=jsonv2&q=1000&addressdetails=1&limit=1&countrycodes=be', (string)$this->nominatim->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Stad Brussel',
            'municipality' => 'Brussel-Hoofdstad',
            'province' => 'Brussels Hoofdstedelijk Gewest',
            'latitude' => 50.84549315,
            'longitude' => 4.36894195312682
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code7()
    {
        $address = $this->nominatim->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '[{"place_id":199518265,"licence":"Data © OpenStreetMap contributors, ODbL 1.0. https://osm.org/copyright","boundingbox":["52.531706506615","52.531806506615","13.387999631428","13.388099631428"],"lat":"52.531756506615","lon":"13.3880496314284","display_name":"Mitte, Berlijn, 10115, Duitsland","place_rank":21,"category":"place","type":"postcode","importance":0.335,"address":{"suburb":"Mitte","city_district":"Mitte","city":"Berlijn","state":"Berlijn","postcode":"10115","country":"Duitsland","country_code":"de"}}]')
            ]),
        ]))->find('10115');

        $this->assertSame('https://nominatim.openstreetmap.org/search?format=jsonv2&q=10115&addressdetails=1&limit=1', (string)$this->nominatim->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Berlijn',
            'municipality' => 'Mitte',
            'province' => 'Berlijn',
            'latitude' => 52.531756506615,
            'longitude' => 13.3880496314284
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code8()
    {
        $address = $this->nominatim->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '[{"place_id":40746909,"licence":"Data © OpenStreetMap contributors, ODbL 1.0. https://osm.org/copyright","osm_type":"node","osm_id":3030683723,"boundingbox":["48.2060295","48.2061295","16.3651188","16.3652188"],"lat":"48.2060795","lon":"16.3651688","display_name":"KG Innere Stadt, Innere Stadt, Wenen, 1010, Oostenrijk","place_rank":21,"category":"place","type":"postcode","importance":0.335,"address":{"suburb":"KG Innere Stadt","city_district":"Innere Stadt","city":"Wenen","state":"Wenen","postcode":"1010","country":"Oostenrijk","country_code":"at"}}]')
            ]),
        ]))->setOptions(['countrycodes' => 'at'])->find('1010');

        $this->assertSame('https://nominatim.openstreetmap.org/search?format=jsonv2&q=1010&addressdetails=1&limit=1&countrycodes=at', (string)$this->nominatim->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Wenen',
            'municipality' => 'KG Innere Stadt',
            'province' => 'Wenen',
            'latitude' => 48.2060795,
            'longitude' => 16.3651688
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_an_invalid_postal_code()
    {
        $address = $this->nominatim->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '[]')
            ]),
        ]))->find('zeroresults');

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


    /** @xx */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_an_invalid_postal_code()
    {
        $this->expectException(NotSupportedException::class);

        $this->nominatim->findByPostcodeAndHouseNumber('1118CP', '202');
    }
}
