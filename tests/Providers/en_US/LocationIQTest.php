<?php

namespace nickurt\PostcodeApi\Tests\Providers\en_US;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Exception\NotSupportedException;
use nickurt\PostcodeApi\Tests\Providers\BaseProviderTest;

class LocationIQTest extends BaseProviderTest
{
    /** @var \nickurt\PostcodeApi\Providers\en_US\LocationIQ */
    protected $locationIQ;

    public function setUp(): void
    {
        $this->locationIQ = (new \nickurt\PostcodeApi\Providers\en_US\LocationIQ())
            ->setRequestUrl('https://us1.locationiq.com/v1/search.php')
            ->setApiKey('4390069143712a');
    }

    /** @test */
    public function it_can_get_the_default_config_values_for_this_provider()
    {
        $this->assertSame('4390069143712a', $this->locationIQ->getApiKey());
        $this->assertSame('https://us1.locationiq.com/v1/search.php', $this->locationIQ->getRequestUrl());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        $address = $this->locationIQ->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '[{"place_id":"225177274","licence":"https:\/\/locationiq.com\/attribution","boundingbox":["33.766085028306","33.766185028306","-116.45253711222","-116.45243711222"],"lat":"33.7661350283064","lon":"-116.452487112216","display_name":"Rancho Mirage, California, USA","class":"place","type":"postcode","importance":0.335,"address":{"city":"Rancho Mirage","state":"California","postcode":"92270","country":"United States of America","country_code":"us","state_code":"ca"}}]')
            ]),
        ]))->setOptions(['countrycodes' => 'US'])->find('92270');

        $this->assertSame('https://us1.locationiq.com/v1/search.php?q=92270&statecode=1&addressdetails=1&format=json&key=4390069143712a&countrycodes=US', $this->locationIQ->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Rancho Mirage',
            'municipality' => 'California',
            'province' => 'California',
            'latitude' => 33.7661350283064,
            'longitude' => -116.452487112216
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code2()
    {
        $address = $this->locationIQ->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '[{"place_id":"224826299","licence":"https:\/\/locationiq.com\/attribution","boundingbox":["52.303491683333","52.303591683333","4.7473538166667","4.7474538166667"],"lat":"52.3035416833333","lon":"4.74740381666667","display_name":"Schiphol, North Holland, Netherlands, 1118CP, The Netherlands","class":"place","type":"postcode","importance":0.335,"address":{"suburb":"Schiphol","state":"North Holland","postcode":"1118CP","country":"The Netherlands","country_code":"nl","town":"Schiphol"}}]')
            ]),
        ]))->setOptions(['countrycodes' => 'NL'])->find('1118CP');

        $this->assertSame('https://us1.locationiq.com/v1/search.php?q=1118CP&statecode=1&addressdetails=1&format=json&key=4390069143712a&countrycodes=NL', $this->locationIQ->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Schiphol',
            'municipality' => 'North Holland',
            'province' => 'North Holland',
            'latitude' => 52.3035416833333,
            'longitude' => 4.74740381666667
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code3()
    {
        $address = $this->locationIQ->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '[{"place_id":"226467527","licence":"https:\/\/locationiq.com\/attribution","boundingbox":["51.50095893648","51.50105893648","-0.14163760012261","-0.14153760012261"],"lat":"51.5010089364798","lon":"-0.141587600122614","display_name":"Westminster, SW1A 1AA, United Kingdom","class":"place","type":"postcode","importance":0.325,"address":{"city":"Westminster","postcode":"SW1A 1AA","country":"United Kingdom","country_code":"gb"}}]')
            ]),
        ]))->find('SW1A%201AA');

        $this->assertSame('https://us1.locationiq.com/v1/search.php?q=SW1A%201AA&statecode=1&addressdetails=1&format=json&key=4390069143712a', $this->locationIQ->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Westminster',
            'municipality' => null,
            'province' => null,
            'latitude' => 51.5010089364798,
            'longitude' => -0.141587600122614
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code4()
    {
        $address = $this->locationIQ->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '[{"place_id":"127865313","licence":"https:\/\/locationiq.com\/attribution","osm_type":"way","osm_id":"191186825","boundingbox":["-37.8014414","-37.8011958","144.9851557","144.9854287"],"lat":"-37.80135805","lon":"144.985285299749","display_name":"Collingwood, City of Yarra, Victoria, 3066, Australia","class":"place","type":"postcode","importance":0.335,"address":{"suburb":"Collingwood","county":"City of Yarra","state":"Victoria","postcode":"3066","country":"Australia","country_code":"au","state_code":"vic","town":"Collingwood"}},{"place_id":"225025966","licence":"https:\/\/locationiq.com\/attribution","boundingbox":["-37.802530182554","-37.802430182554","144.98658088497","144.98668088497"],"lat":"-37.8024801825543","lon":"144.986630884971","display_name":"Collingwood, Victoria, 3066, Australia","class":"place","type":"postcode","importance":0.335,"address":{"suburb":"Collingwood","state":"Victoria","postcode":"3066","country":"Australia","country_code":"au","state_code":"vic","town":"Collingwood"}},{"place_id":"61672858","licence":"https:\/\/locationiq.com\/attribution","osm_type":"node","osm_id":"5190396194","boundingbox":["-35.2998372","-35.2997372","149.1649843","149.1650843"],"lat":"-35.2997872","lon":"149.1650343","display_name":"Parnell Street before Plant Road, Parnell Road, Duntroon, Campbell, Canberra, District of Canberra Central, Australian Capital Territory, 2612, Australia","class":"highway","type":"bus_stop","importance":0.001,"icon":"https:\/\/locationiq.org\/static\/images\/mapicons\/transport_bus_stop2.p.20.png","address":{"bus_stop":"Parnell Street before Plant Road","road":"Parnell Road","neighbourhood":"Duntroon","suburb":"Campbell","city":"Canberra","county":"District of Canberra Central","state":"Australian Capital Territory","postcode":"2612","country":"Australia","country_code":"au","state_code":"act"}}]')
            ]),
        ]))->setOptions(['countrycodes' => 'au'])->find('3066');

        $this->assertSame('https://us1.locationiq.com/v1/search.php?q=3066&statecode=1&addressdetails=1&format=json&key=4390069143712a&countrycodes=au', $this->locationIQ->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Collingwood',
            'municipality' => 'City of Yarra',
            'province' => 'Victoria',
            'latitude' => -37.80135805,
            'longitude' => 144.985285299749
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code5()
    {
        $address = $this->locationIQ->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '[{"place_id":"223046547","licence":"https:\/\/locationiq.com\/attribution","osm_type":"relation","osm_id":"1019356","boundingbox":["48.8546254","48.8548927","2.3245589","2.3248901"],"lat":"48.85475725","lon":"2.32478947294153","display_name":"St-Thomas-d\'Aquin, 7th Arrondissement, Paris, Ile-de-France, Metropolitan France, 75007, France","class":"place","type":"postcode","importance":0.335,"address":{"suburb":"St-Thomas-d\'Aquin","city_district":"7th Arrondissement","city":"Paris","county":"Paris","state":"Ile-de-France","country":"France","postcode":"75007","country_code":"fr"}},{"place_id":"211284348","licence":"https:\/\/locationiq.com\/attribution","osm_type":"way","osm_id":"643343004","boundingbox":["48.8547329","48.8571924","2.3101504","2.3144774"],"lat":"48.85594575","lon":"2.31238279778226","display_name":"Invalides, 7th Arrondissement, Paris, Ile-de-France, Metropolitan France, 75007, France","class":"place","type":"postcode","importance":0.335,"address":{"suburb":"Invalides","city_district":"7th Arrondissement","city":"Paris","county":"Paris","state":"Ile-de-France","country":"France","postcode":"75007","country_code":"fr"}},{"place_id":"224576912","licence":"https:\/\/locationiq.com\/attribution","boundingbox":["48.855855822418","48.855955822418","2.3138098210398","2.3139098210398"],"lat":"48.8559058224182","lon":"2.31385982103981","display_name":"Invalides, Ile-de-France, Metropolitan France, 75007, France","class":"place","type":"postcode","importance":0.335,"address":{"suburb":"Invalides","state":"Ile-de-France","country":"France","postcode":"75007","country_code":"fr","town":"Invalides"}}]')
            ]),
        ]))->setOptions(['countrycodes' => 'fr'])->find('75007');

        $this->assertSame('https://us1.locationiq.com/v1/search.php?q=75007&statecode=1&addressdetails=1&format=json&key=4390069143712a&countrycodes=fr', $this->locationIQ->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Paris',
            'municipality' => 'Paris',
            'province' => 'Ile-de-France',
            'latitude' => 48.85475725,
            'longitude' => 2.32478947294153
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code6()
    {
        $address = $this->locationIQ->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '[{"place_id":"173066470","licence":"https:\/\/locationiq.com\/attribution","osm_type":"way","osm_id":"396533093","boundingbox":["50.8450652","50.8459437","4.3679111","4.3696763"],"lat":"50.84549315","lon":"4.36894195312682","display_name":"Brussels, Ville de Bruxelles - Stad Brussel, Brussels-Capital, 1000, Belgium","class":"place","type":"postcode","importance":0.4570698843996,"address":{"city_district":"Brussels","city":"Ville de Bruxelles - Stad Brussel","county":"Brussels-Capital","state":"Brussels-Capital","postcode":"1000","country":"Belgium","country_code":"be"}},{"place_id":"173066103","licence":"https:\/\/locationiq.com\/attribution","osm_type":"way","osm_id":"396533098","boundingbox":["50.8453492","50.8466282","4.3614461","4.362966"],"lat":"50.8461217","lon":"4.36226027753893","display_name":"Quartier Royal - Koninklijke Wijk, Brussels, Ville de Bruxelles - Stad Brussel, Brussels-Capital, 1000, Belgium","class":"place","type":"postcode","importance":0.400701435537,"address":{"suburb":"Quartier Royal - Koninklijke Wijk","city_district":"Brussels","city":"Ville de Bruxelles - Stad Brussel","county":"Brussels-Capital","state":"Brussels-Capital","postcode":"1000","country":"Belgium","country_code":"be"}},{"place_id":"186934473","licence":"https:\/\/locationiq.com\/attribution","osm_type":"way","osm_id":"471889051","boundingbox":["50.846017","50.846974","4.3582163","4.3593505"],"lat":"50.8464969","lon":"4.35880143265351","display_name":"Quartier de la Cath\u00e9drale, Brussels, Ville de Bruxelles - Stad Brussel, Brussels-Capital, 1000, Belgium","class":"place","type":"postcode","importance":0.39421533777039,"address":{"suburb":"Quartier de la Cath\u00e9drale","city_district":"Brussels","city":"Ville de Bruxelles - Stad Brussel","county":"Brussels-Capital","state":"Brussels-Capital","postcode":"1000","country":"Belgium","country_code":"be"}},{"place_id":"173049507","licence":"https:\/\/locationiq.com\/attribution","osm_type":"way","osm_id":"396446815","boundingbox":["50.8469015","50.8488322","4.3480723","4.3502449"],"lat":"50.8474831","lon":"4.34876116686653","display_name":"Quartier du Centre - Centrumwijk, Brussels, Ville de Bruxelles - Stad Brussel, Brussels-Capital, 1000, Belgium","class":"place","type":"postcode","importance":0.35591738766298,"address":{"suburb":"Quartier du Centre - Centrumwijk","city_district":"Brussels","city":"Ville de Bruxelles - Stad Brussel","county":"Brussels-Capital","state":"Brussels-Capital","postcode":"1000","country":"Belgium","country_code":"be"}},{"place_id":"225022978","licence":"https:\/\/locationiq.com\/attribution","boundingbox":["50.847914651035","50.848014651035","4.3600870196544","4.3601870196544"],"lat":"50.8479646510346","lon":"4.36013701965444","display_name":"Quartier de la Cath\u00e9drale, Brussels-Capital, 1000, Belgium","class":"place","type":"postcode","importance":0.335,"address":{"suburb":"Quartier de la Cath\u00e9drale","state":"Brussels-Capital","postcode":"1000","country":"Belgium","country_code":"be","town":"Quartier de la Cath\u00e9drale"}},{"place_id":"137250376","licence":"https:\/\/locationiq.com\/attribution","osm_type":"way","osm_id":"224651335","boundingbox":["50.8423065","50.8425477","4.3504941","4.3511391"],"lat":"50.8424142","lon":"4.35085996688676","display_name":"Quartier Midi-Lemonnier - Zuid-Lemonnierwijk, Brussels, Ville de Bruxelles - Stad Brussel, Brussels-Capital, 1000, Belgium","class":"place","type":"postcode","importance":0.335,"address":{"suburb":"Quartier Midi-Lemonnier - Zuid-Lemonnierwijk","city_district":"Brussels","city":"Ville de Bruxelles - Stad Brussel","county":"Brussels-Capital","state":"Brussels-Capital","postcode":"1000","country":"Belgium","country_code":"be"}}]')
            ]),
        ]))->setOptions(['countrycodes' => 'be'])->find('1000');

        $this->assertSame('https://us1.locationiq.com/v1/search.php?q=1000&statecode=1&addressdetails=1&format=json&key=4390069143712a&countrycodes=be', $this->locationIQ->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Ville de Bruxelles - Stad Brussel',
            'municipality' => 'Brussels-Capital',
            'province' => 'Brussels-Capital',
            'latitude' => 50.84549315,
            'longitude' => 4.36894195312682
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code7()
    {
        $address = $this->locationIQ->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '[{"place_id":"165784127","licence":"https:\/\/locationiq.com\/attribution","osm_type":"way","osm_id":"360831867","boundingbox":["52.5327733","52.5331175","13.3953411","13.3959245"],"lat":"52.5329396","lon":"13.3956331471092","display_name":"Mitte, Berlin, 10115, Germany","class":"place","type":"postcode","importance":0.335,"address":{"suburb":"Mitte","city_district":"Mitte","city":"Berlin","state":"Berlin","postcode":"10115","country":"Germany","country_code":"de"}},{"place_id":"224420771","licence":"https:\/\/locationiq.com\/attribution","boundingbox":["52.531732123488","52.531832123488","13.387968833438","13.388068833438"],"lat":"52.5317821234875","lon":"13.3880188334384","display_name":"Mitte, Berlin, 10115, Germany","class":"place","type":"postcode","importance":0.335,"address":{"suburb":"Mitte","state":"Berlin","postcode":"10115","country":"Germany","country_code":"de","town":"Mitte"}},{"place_id":"223067391","licence":"https:\/\/locationiq.com\/attribution","osm_type":"relation","osm_id":"1402156","boundingbox":["52.5237433","52.5401484","13.3658603","13.4012965"],"lat":"52.53195385","lon":"13.3838001271759","display_name":"Mitte, Berlin, 10115, Germany","class":"place","type":"postcode","importance":0.335,"address":{"suburb":"Mitte","city_district":"Mitte","city":"Berlin","state":"Berlin","postcode":"10115","country":"Germany","country_code":"de"}}]')
            ]),
        ]))->setOptions(['countrycodes' => 'de'])->find('10115');

        $this->assertSame('https://us1.locationiq.com/v1/search.php?q=10115&statecode=1&addressdetails=1&format=json&key=4390069143712a&countrycodes=de', $this->locationIQ->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Berlin',
            'municipality' => 'Berlin',
            'province' => 'Berlin',
            'latitude' => 52.5329396,
            'longitude' => 13.3956331471092
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code8()
    {
        $address = $this->locationIQ->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '[{"place_id":"106638855","licence":"https:\/\/locationiq.com\/attribution","osm_type":"way","osm_id":"107670253","boundingbox":["48.211107","48.2114214","16.3625784","16.3630268"],"lat":"48.2112564","lon":"16.3628052370435","display_name":"KG Innere Stadt, Innere Stadt, Vienna, 1010, Austria","class":"place","type":"postcode","importance":0.335,"address":{"suburb":"KG Innere Stadt","city_district":"Innere Stadt","city":"Vienna","state":"Vienna","postcode":"1010","country":"Austria","country_code":"at"}},{"place_id":"40317723","licence":"https:\/\/locationiq.com\/attribution","osm_type":"node","osm_id":"3030683723","boundingbox":["48.2060295","48.2061295","16.3651188","16.3652188"],"lat":"48.2060795","lon":"16.3651688","display_name":"KG Innere Stadt, Innere Stadt, Vienna, 1010, Austria","class":"place","type":"postcode","importance":0.335,"address":{"suburb":"KG Innere Stadt","city_district":"Innere Stadt","city":"Vienna","state":"Vienna","postcode":"1010","country":"Austria","country_code":"at"}},{"place_id":"223896784","licence":"https:\/\/locationiq.com\/attribution","osm_type":"relation","osm_id":"7917275","boundingbox":["48.1995278","48.2184891","16.3552089","16.3848946"],"lat":"48.2090229","lon":"16.3698511256966","display_name":"KG Innere Stadt, Innere Stadt, Vienna, 1010, Austria","class":"place","type":"postcode","importance":0.335,"address":{"suburb":"KG Innere Stadt","city_district":"Innere Stadt","city":"Vienna","state":"Vienna","postcode":"1010","country":"Austria","country_code":"at"}},{"place_id":"224380658","licence":"https:\/\/locationiq.com\/attribution","boundingbox":["48.208691410177","48.208791410177","16.370686748498","16.370786748498"],"lat":"48.2087414101768","lon":"16.3707367484983","display_name":"KG Innere Stadt, Vienna, 1010, Austria","class":"place","type":"postcode","importance":0.335,"address":{"suburb":"KG Innere Stadt","state":"Vienna","postcode":"1010","country":"Austria","country_code":"at","town":"KG Innere Stadt"}},{"place_id":"292368","licence":"https:\/\/locationiq.com\/attribution","osm_type":"node","osm_id":"76510695","boundingbox":["48.2102354","48.2103354","16.3785543","16.3786543"],"lat":"48.2102854","lon":"16.3786043","display_name":"1010 Wien, 19, Fleischmarkt, Stubenviertel, KG Innere Stadt, Innere Stadt, Vienna, 1010, Austria","class":"amenity","type":"post_office","importance":0.111,"icon":"https:\/\/locationiq.org\/static\/images\/mapicons\/amenity_post_office.p.20.png","address":{"post_office":"1010 Wien","house_number":"19","road":"Fleischmarkt","neighbourhood":"Stubenviertel","suburb":"KG Innere Stadt","city_district":"Innere Stadt","city":"Vienna","state":"Vienna","postcode":"1010","country":"Austria","country_code":"at"}}]')
            ]),
        ]))->setOptions(['countrycodes' => 'at'])->find('1010');

        $this->assertSame('https://us1.locationiq.com/v1/search.php?q=1010&statecode=1&addressdetails=1&format=json&key=4390069143712a&countrycodes=at', $this->locationIQ->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Vienna',
            'municipality' => 'Vienna',
            'province' => 'Vienna',
            'latitude' => 48.2112564,
            'longitude' => 16.3628052370435
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_an_invalid_postal_code()
    {
        // GuzzleHttp\Exception\ClientException: Client error: `GET https://us1.locationiq.com/v1/search.php?q=zeroresults&statecode=1&addressdetails=1&format=json&key=4390069143712a` resulted in a `404 Not Found` response:
        // {"error":"Unable to geocode"}

        $address = $this->locationIQ->setHttpClient(new Client([
            'handler' => MockHandler::createWithMiddleware([
                new Response(404, [], '{"error":"Unable to geocode"}')
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

    /** @test */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_a_valid_postal_code()
    {
        $this->expectException(NotSupportedException::class);

        $this->locationIQ->findByPostcodeAndHouseNumber('1118CP', '202');
    }
}
