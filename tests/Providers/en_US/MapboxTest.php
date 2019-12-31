<?php

namespace nickurt\PostcodeApi\tests\Providers\en_US;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Exceptions\NotSupportedException;
use nickurt\PostcodeApi\tests\Providers\BaseProviderTest;

class MapboxTest extends BaseProviderTest
{
    /** @var \nickurt\PostcodeApi\Providers\en_US\Mapbox */
    protected $mapBox;

    public function setUp(): void
    {
        $this->mapBox = (new \nickurt\PostcodeApi\Providers\en_US\Mapbox())
            ->setApiKey('pk.hd5FuVYvSRnJwzSQ2LJyyFQSWXuJEN5wTzgtGFcgxpWxRrWtATeQYLEuJxnPnqXAMZ.Or19S7KmYPHW8YjRz82v6g');
    }

    /** @test */
    public function it_can_get_the_default_config_values_for_this_provider()
    {
        $this->assertSame('pk.hd5FuVYvSRnJwzSQ2LJyyFQSWXuJEN5wTzgtGFcgxpWxRrWtATeQYLEuJxnPnqXAMZ.Or19S7KmYPHW8YjRz82v6g', $this->mapBox->getApiKey());
        $this->assertSame('https://api.mapbox.com/geocoding/v5/mapbox.places/%s.json', $this->mapBox->getRequestUrl());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        $address = $this->mapBox->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"type":"FeatureCollection","query":["92270"],"features":[{"id":"postcode.15427044189040950","type":"Feature","place_type":["postcode"],"relevance":1,"properties":{},"text":"92270","place_name":"Rancho Mirage, California 92270, United States","bbox":[-116.477902764177,33.713620261716,-116.388148990092,33.8363459082474],"center":[-116.41,33.74],"geometry":{"type":"Point","coordinates":[-116.41,33.74]},"context":[{"id":"place.15741035131817860","wikidata":"Q506446","text":"Rancho Mirage"},{"id":"region.11319063928738010","short_code":"US-CA","wikidata":"Q99","text":"California"},{"id":"country.9053006287256050","short_code":"us","wikidata":"Q30","text":"United States"}]},{"id":"postcode.13766930288040950","type":"Feature","place_type":["postcode"],"relevance":1,"properties":{},"text":"92270","place_name":"92270, Bois-Colombes, Hauts-de-Seine, France","bbox":[2.257024,48.903441,2.280645,48.926848],"center":[2.26,48.91],"geometry":{"type":"Point","coordinates":[2.26,48.91]},"context":[{"id":"place.13766930289838090","wikidata":"Q212566","text":"Bois-Colombes"},{"id":"region.13694880457133190","short_code":"FR-92","wikidata":"Q12543","text":"Hauts-de-Seine"},{"id":"country.9865485196641660","short_code":"fr","wikidata":"Q142","text":"France"}]},{"id":"postcode.1626947935040950","type":"Feature","place_type":["postcode"],"relevance":1,"properties":{},"text":"92270","place_name":"92270, Ixcatepec, Veracruz de Ignacio de la Llave, Mexico","bbox":[-98.0141478206708,21.2294450539657,-97.9995328409561,21.2447805408279],"center":[-98.006421,21.237061],"geometry":{"type":"Point","coordinates":[-98.006421,21.237061]},"context":[{"id":"place.4081797651269890","wikidata":"Q20269345","text":"Ixcatepec"},{"id":"region.14234208716791070","short_code":"MX-VER","wikidata":"Q60130","text":"Veracruz de Ignacio de la Llave"},{"id":"country.1891876083773450","short_code":"mx","wikidata":"Q96","text":"Mexico"}]},{"id":"postcode.2310269655040950","type":"Feature","place_type":["postcode"],"relevance":1,"properties":{},"text":"92270","place_name":"92270, Porto Alegre, Rio Grande Do Sul, Brazil","center":[-51.111551,-30.034828],"geometry":{"type":"Point","coordinates":[-51.111551,-30.034828]},"context":[{"id":"place.7566766381042150","wikidata":"Q40269","text":"Porto Alegre"},{"id":"region.10641826217890480","short_code":"BR-RS","wikidata":"Q40030","text":"Rio Grande Do Sul"},{"id":"country.12447454793682710","short_code":"br","wikidata":"Q155","text":"Brazil"}]}],"attribution":"NOTICE: © 2019 Mapbox and its suppliers. All rights reserved. Use of this data is subject to the Mapbox Terms of Service (https://www.mapbox.com/about/maps/). This response and the information it contains may not be retained. POI(s) provided by Foursquare."}')
            ]),
        ]))->find('92270');

        $this->assertSame('https://api.mapbox.com/geocoding/v5/mapbox.places/92270.json?access_token=pk.hd5FuVYvSRnJwzSQ2LJyyFQSWXuJEN5wTzgtGFcgxpWxRrWtATeQYLEuJxnPnqXAMZ.Or19S7KmYPHW8YjRz82v6g', (string)$this->mapBox->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Rancho Mirage',
            'municipality' => null,
            'province' => 'California',
            'latitude' => 33.74,
            'longitude' => -116.41
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code2()
    {
        $address = $this->mapBox->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"type":"FeatureCollection","query":["1118cp"],"features":[{"id":"postcode.8471218600783820","type":"Feature","place_type":["postcode"],"relevance":1,"properties":{},"text":"1118 CP","place_name":"1118 CP, Schiphol, Noord-Holland, Netherlands","matching_text":"1118CP","matching_place_name":"1118CP, Schiphol, Noord-Holland, Netherlands","bbox":[4.732591,52.301577,4.752121,52.317023],"center":[4.738576,52.310231],"geometry":{"type":"Point","coordinates":[4.738576,52.310231]},"context":[{"id":"place.6902660827471509","wikidata":"Q9694","text":"Schiphol"},{"id":"region.7726365174279220","short_code":"NL-NH","wikidata":"Q701","text":"Noord-Holland"},{"id":"country.9349515904622050","short_code":"nl","wikidata":"Q55","text":"Netherlands"}]}],"attribution":"NOTICE: © 2019 Mapbox and its suppliers. All rights reserved. Use of this data is subject to the Mapbox Terms of Service (https://www.mapbox.com/about/maps/). This response and the information it contains may not be retained. POI(s) provided by Foursquare."}')
            ]),
        ]))->find('1118CP');

        $this->assertSame('https://api.mapbox.com/geocoding/v5/mapbox.places/1118CP.json?access_token=pk.hd5FuVYvSRnJwzSQ2LJyyFQSWXuJEN5wTzgtGFcgxpWxRrWtATeQYLEuJxnPnqXAMZ.Or19S7KmYPHW8YjRz82v6g', (string)$this->mapBox->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Schiphol',
            'municipality' => null,
            'province' => 'Noord-Holland',
            'latitude' => 52.310231,
            'longitude' => 4.738576
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code3()
    {
        $address = $this->mapBox->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"type":"FeatureCollection","query":["sw1a1aa"],"features":[{"id":"postcode.8462203201439070","type":"Feature","place_type":["postcode"],"relevance":1,"properties":{},"text":"SW1A 1AA","place_name":"SW1A 1AA, London, Greater London, England, United Kingdom","matching_text":"SW1A1AA","matching_place_name":"SW1A1AA, London, Greater London, England, United Kingdom","bbox":[-0.149113,51.499385,-0.135508,51.503816],"center":[-0.1415876,51.5010092],"geometry":{"type":"Point","coordinates":[-0.1415876,51.5010092]},"context":[{"id":"place.2703042976503000","wikidata":"Q84","text":"London"},{"id":"district.9655698107976620","wikidata":"Q23306","text":"Greater London"},{"id":"region.10000087231453920","short_code":"GB-ENG","wikidata":"Q21","text":"England"},{"id":"country.8605848117814600","short_code":"gb","wikidata":"Q145","text":"United Kingdom"}]}],"attribution":"NOTICE: © 2019 Mapbox and its suppliers. All rights reserved. Use of this data is subject to the Mapbox Terms of Service (https://www.mapbox.com/about/maps/). This response and the information it contains may not be retained. POI(s) provided by Foursquare."}')
            ]),
        ]))->find('SW1A1AA');

        $this->assertSame('https://api.mapbox.com/geocoding/v5/mapbox.places/SW1A1AA.json?access_token=pk.hd5FuVYvSRnJwzSQ2LJyyFQSWXuJEN5wTzgtGFcgxpWxRrWtATeQYLEuJxnPnqXAMZ.Or19S7KmYPHW8YjRz82v6g', (string)$this->mapBox->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'London',
            'municipality' => null,
            'province' => 'England',
            'latitude' => 51.5010092,
            'longitude' => -0.1415876
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code4()
    {
        $address = $this->mapBox->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"type":"FeatureCollection","query":["3066"],"features":[{"id":"postcode.17616803905247540","type":"Feature","place_type":["postcode"],"relevance":1,"properties":{},"text":"3066","place_name":"3066, Melbourne, Victoria, Australia","bbox":[144.982553,-37.809737,144.993614,-37.794169],"center":[144.99,-37.8],"geometry":{"type":"Point","coordinates":[144.99,-37.8]},"context":[{"id":"place.7068896531111320","wikidata":"Q3141","text":"Melbourne"},{"id":"region.10354338764038050","short_code":"AU-VIC","wikidata":"Q36687","text":"Victoria"},{"id":"country.3050683007346070","short_code":"au","wikidata":"Q408","text":"Australia"}]},{"id":"postcode.5739725918247540","type":"Feature","place_type":["postcode"],"relevance":1,"properties":{},"text":"3066","place_name":"3066, Stettlen, Bern, Switzerland","bbox":[7.507419,46.943842,7.549977,46.982077],"center":[7.53,46.96],"geometry":{"type":"Point","coordinates":[7.53,46.96]},"context":[{"id":"place.3069794937102592","wikidata":"Q70052","text":"Stettlen"},{"id":"region.11657871833960580","short_code":"CH-BE","wikidata":"Q11911","text":"Bern"},{"id":"country.14796626434437020","short_code":"ch","wikidata":"Q39","text":"Switzerland"}]},{"id":"postcode.6936693387247540","type":"Feature","place_type":["postcode"],"relevance":1,"properties":{},"text":"3066","place_name":"3066, Kutasó, Nógrád, Hungary","bbox":[19.509241,47.918359,19.60125,47.975029],"center":[19.555427,47.946995],"geometry":{"type":"Point","coordinates":[19.555427,47.946995]},"context":[{"id":"place.9267188470947180","wikidata":"Q545733","text":"Kutasó"},{"id":"region.18234437850098240","short_code":"HU-NO","wikidata":"Q194273","text":"Nógrád"},{"id":"country.10104158949164800","short_code":"hu","wikidata":"Q28","text":"Hungary"}]},{"id":"address.1775312555587314","type":"Feature","place_type":["address"],"relevance":1,"properties":{"accuracy":"street"},"text":"3066","place_name":"3066, Rochester, Indiana 46975, United States","center":[-86.2036801611254,41.0429487886],"geometry":{"type":"Point","coordinates":[-86.2036801611254,41.0429487886]},"context":[{"id":"postcode.13106354167586950","text":"46975"},{"id":"place.9953940721320780","wikidata":"Q991186","text":"Rochester"},{"id":"region.18316833095766400","short_code":"US-IN","wikidata":"Q1415","text":"Indiana"},{"id":"country.9053006287256050","short_code":"us","wikidata":"Q30","text":"United States"}]},{"id":"address.6675769593422214","type":"Feature","place_type":["address"],"relevance":1,"properties":{"accuracy":"street"},"text":"Beacon Hills Drive","place_name":"Beacon Hills Drive, Gastonia, North Carolina 28056, United States","matching_text":"3066","matching_place_name":"3066, Gastonia, North Carolina 28056, United States","center":[-81.1033859,35.208062],"geometry":{"type":"Point","coordinates":[-81.1033859,35.208062]},"context":[{"id":"postcode.10331004914813450","text":"28056"},{"id":"place.7585631671363970","wikidata":"Q943775","text":"Gastonia"},{"id":"region.2248353445854480","short_code":"US-NC","wikidata":"Q1454","text":"North Carolina"},{"id":"country.9053006287256050","short_code":"us","wikidata":"Q30","text":"United States"}]}],"attribution":"NOTICE: © 2019 Mapbox and its suppliers. All rights reserved. Use of this data is subject to the Mapbox Terms of Service (https://www.mapbox.com/about/maps/). This response and the information it contains may not be retained. POI(s) provided by Foursquare."}')
            ]),
        ]))->find('3066');

        $this->assertSame('https://api.mapbox.com/geocoding/v5/mapbox.places/3066.json?access_token=pk.hd5FuVYvSRnJwzSQ2LJyyFQSWXuJEN5wTzgtGFcgxpWxRrWtATeQYLEuJxnPnqXAMZ.Or19S7KmYPHW8YjRz82v6g', (string)$this->mapBox->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Melbourne',
            'municipality' => null,
            'province' => 'Victoria',
            'latitude' => -37.8,
            'longitude' => 144.99
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code5()
    {
        $address = $this->mapBox->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"type":"FeatureCollection","query":["75007"],"features":[{"id":"postcode.12325909718936270","type":"Feature","place_type":["postcode"],"relevance":1,"properties":{},"text":"75007","place_name":"75007, Paris, France","bbox":[2.289913,48.845896,2.333345,48.863823],"center":[2.33,48.86],"geometry":{"type":"Point","coordinates":[2.33,48.86]},"context":[{"id":"place.12421817726497330","short_code":"FR-75","wikidata":"Q90","text":"Paris"},{"id":"country.9865485196641660","short_code":"fr","wikidata":"Q142","text":"France"}]},{"id":"postcode.4107735915936270","type":"Feature","place_type":["postcode"],"relevance":1,"properties":{},"text":"75007","place_name":"Carrollton, Texas 75007, United States","bbox":[-96.948532929656,32.9820400022471,-96.8432642311421,33.0286273913445],"center":[-96.88,33.02],"geometry":{"type":"Point","coordinates":[-96.88,33.02]},"context":[{"id":"place.8987931462988030","wikidata":"Q128261","text":"Carrollton"},{"id":"region.5362387429342410","short_code":"US-TX","wikidata":"Q1439","text":"Texas"},{"id":"country.9053006287256050","short_code":"us","wikidata":"Q30","text":"United States"}]},{"id":"postcode.12212467889160610","type":"Feature","place_type":["postcode"],"relevance":1,"properties":{},"text":"750 07","place_name":"750 07, Přerov, Olomoucký, Czech Republic","matching_text":"75007","matching_place_name":"75007, Přerov, Olomoucký, Czech Republic","bbox":[17.460562,49.433445,17.461562,49.434445],"center":[17.461062,49.433945],"geometry":{"type":"Point","coordinates":[17.461062,49.433945]},"context":[{"id":"place.7130844653296810","wikidata":"Q470380","text":"Přerov"},{"id":"region.3008417104888950","short_code":"CZ-OL","wikidata":"Q193307","text":"Olomoucký"},{"id":"country.7012406632547630","short_code":"cz","wikidata":"Q213","text":"Czech Republic"}]},{"id":"postcode.11005058897936270","type":"Feature","place_type":["postcode"],"relevance":1,"properties":{},"text":"75007","place_name":"75007, Anápolis, Goiás, Brazil","center":[-48.955025,-16.29449],"geometry":{"type":"Point","coordinates":[-48.955025,-16.29449]},"context":[{"id":"place.12970676018522080","wikidata":"Q223422","text":"Anápolis"},{"id":"region.5817894906371410","short_code":"BR-GO","wikidata":"Q41587","text":"Goiás"},{"id":"country.12447454793682710","short_code":"br","wikidata":"Q155","text":"Brazil"}]}],"attribution":"NOTICE: © 2019 Mapbox and its suppliers. All rights reserved. Use of this data is subject to the Mapbox Terms of Service (https://www.mapbox.com/about/maps/). This response and the information it contains may not be retained. POI(s) provided by Foursquare."}')
            ]),
        ]))->find('75007');

        $this->assertSame('https://api.mapbox.com/geocoding/v5/mapbox.places/75007.json?access_token=pk.hd5FuVYvSRnJwzSQ2LJyyFQSWXuJEN5wTzgtGFcgxpWxRrWtATeQYLEuJxnPnqXAMZ.Or19S7KmYPHW8YjRz82v6g', (string)$this->mapBox->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Paris',
            'municipality' => null,
            'province' => null,
            'latitude' => 48.86,
            'longitude' => 2.33
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code6()
    {
        $address = $this->mapBox->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"type":"FeatureCollection","query":["1000"],"features":[{"id":"postcode.3720986364230240","type":"Feature","place_type":["postcode"],"relevance":1,"properties":{},"text":"1000","place_name":"1000, Brussels, Brussels Hoofstedelijk Gewest, Belgium","bbox":[4.335496,50.796002,4.401712,50.890363],"center":[4.35,50.85],"geometry":{"type":"Point","coordinates":[4.35,50.85]},"context":[{"id":"place.10706876915101710","wikidata":"Q239","text":"Brussels"},{"id":"region.4467477407708110","wikidata":"Q240","text":"Brussels Hoofstedelijk Gewest"},{"id":"country.2136302083110250","short_code":"be","wikidata":"Q31","text":"Belgium"}]}],"attribution":"NOTICE: © 2019 Mapbox and its suppliers. All rights reserved. Use of this data is subject to the Mapbox Terms of Service (https://www.mapbox.com/about/maps/). This response and the information it contains may not be retained. POI(s) provided by Foursquare."}')
            ]),
        ]))->setOptions(['country' => 'be'])->find('1000');

        $this->assertSame('https://api.mapbox.com/geocoding/v5/mapbox.places/1000.json?access_token=pk.hd5FuVYvSRnJwzSQ2LJyyFQSWXuJEN5wTzgtGFcgxpWxRrWtATeQYLEuJxnPnqXAMZ.Or19S7KmYPHW8YjRz82v6g&country=be', (string)$this->mapBox->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Brussels',
            'municipality' => null,
            'province' => 'Brussels Hoofstedelijk Gewest',
            'latitude' => 50.85,
            'longitude' => 4.35
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code7()
    {
        $address = $this->mapBox->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"type":"FeatureCollection","query":["10115"],"features":[{"id":"postcode.6742077699864690","type":"Feature","place_type":["postcode"],"relevance":1,"properties":{},"text":"10115","place_name":"10115, Berlin, Germany","bbox":[13.366091,52.523686,13.401329,52.54013],"center":[13.39,52.53],"geometry":{"type":"Point","coordinates":[13.39,52.53]},"context":[{"id":"place.14880313158564380","short_code":"DE-BE","wikidata":"Q64","text":"Berlin"},{"id":"country.10743216036480410","short_code":"de","wikidata":"Q183","text":"Germany"}]},{"id":"postcode.10541673012864690","type":"Feature","place_type":["postcode"],"relevance":1,"properties":{},"text":"10115","place_name":"10115, Gimpo-si, Gyeonggi-do, South Korea","bbox":[126.721564053459,37.600574492626,126.732336651956,37.6046177580386],"center":[126.726819,37.602692],"geometry":{"type":"Point","coordinates":[126.726819,37.602692]},"context":[{"id":"place.6410160583751010","wikidata":"Q42080","text":"Gimpo-si"},{"id":"region.13038904982125580","wikidata":"Q20937","text":"Gyeonggi-do"},{"id":"country.7031349480995940","short_code":"kr","wikidata":"Q884","text":"South Korea"}]},{"id":"postcode.5412783401864690","type":"Feature","place_type":["postcode"],"relevance":1,"properties":{},"text":"10115","place_name":"New York, New York 10115, United States","bbox":[-73.9644257509438,40.8103712922348,-73.9630562444689,40.8113321561053],"center":[-73.963742,40.810851],"geometry":{"type":"Point","coordinates":[-73.963742,40.810851]},"context":[{"id":"place.15278078705964500","wikidata":"Q60","text":"New York"},{"id":"region.14044236392855570","short_code":"US-NY","wikidata":"Q1384","text":"New York"},{"id":"country.9053006287256050","short_code":"us","wikidata":"Q30","text":"United States"}]},{"id":"address.3008174921765000","type":"Feature","place_type":["address"],"relevance":1,"properties":{"accuracy":"street"},"text":"10115","place_name":"10115, Glen Saint Mary, Florida 32040, United States","center":[-82.210443,30.203556],"geometry":{"type":"Point","coordinates":[-82.210443,30.203556]},"context":[{"id":"postcode.7963058514695100","text":"32040"},{"id":"place.16940101580747900","wikidata":"Q1401310","text":"Glen Saint Mary"},{"id":"region.12218597351235010","short_code":"US-FL","wikidata":"Q812","text":"Florida"},{"id":"country.9053006287256050","short_code":"us","wikidata":"Q30","text":"United States"}]},{"id":"address.4306311256597176","type":"Feature","place_type":["address"],"relevance":1,"properties":{"accuracy":"street"},"text":"10115","place_name":"10115, Perry, Florida 32348, United States","center":[-83.6531109,29.9791181],"geometry":{"type":"Point","coordinates":[-83.6531109,29.9791181]},"context":[{"id":"postcode.3096464775093150","text":"32348"},{"id":"place.4041911881360490","wikidata":"Q1065467","text":"Perry"},{"id":"region.12218597351235010","short_code":"US-FL","wikidata":"Q812","text":"Florida"},{"id":"country.9053006287256050","short_code":"us","wikidata":"Q30","text":"United States"}]}],"attribution":"NOTICE: © 2019 Mapbox and its suppliers. All rights reserved. Use of this data is subject to the Mapbox Terms of Service (https://www.mapbox.com/about/maps/). This response and the information it contains may not be retained. POI(s) provided by Foursquare."}')
            ]),
        ]))->find('10115');

        $this->assertSame('https://api.mapbox.com/geocoding/v5/mapbox.places/10115.json?access_token=pk.hd5FuVYvSRnJwzSQ2LJyyFQSWXuJEN5wTzgtGFcgxpWxRrWtATeQYLEuJxnPnqXAMZ.Or19S7KmYPHW8YjRz82v6g', (string)$this->mapBox->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Berlin',
            'municipality' => null,
            'province' => null,
            'latitude' => 52.53,
            'longitude' => 13.39
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code8()
    {
        $address = $this->mapBox->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"type":"FeatureCollection","query":["1010"],"features":[{"id":"postcode.13989918056853140","type":"Feature","place_type":["postcode"],"relevance":1,"properties":{},"text":"1010","place_name":"1010, Innere Stadt, Wien, Austria","bbox":[16.355059,48.199427,16.384839,48.218629],"center":[16.37,48.21],"geometry":{"type":"Point","coordinates":[16.37,48.21]},"context":[{"id":"place.13989918055915290","wikidata":"Q267329","text":"Innere Stadt"},{"id":"region.13927340704912510","short_code":"AT-9","wikidata":"Q1741","text":"Wien"},{"id":"country.9066292634018400","short_code":"at","wikidata":"Q40","text":"Austria"}]},{"id":"poi.1872605748311","type":"Feature","place_type":["poi"],"relevance":1,"properties":{"landmark":true,"address":"Plankengasse 2","category":"cafe, coffee, tea, tea house","maki":"cafe"},"text":"1010 BAR CAFE","place_name":"1010 BAR CAFE, Plankengasse 2, Innere Stadt, Wien 1010, Austria","center":[16.370218,48.206445],"geometry":{"coordinates":[16.370218,48.206445],"type":"Point"},"context":[{"id":"postcode.13989918056853140","text":"1010"},{"id":"place.13989918055915290","wikidata":"Q267329","text":"Innere Stadt"},{"id":"region.13927340704912510","short_code":"AT-9","wikidata":"Q1741","text":"Wien"},{"id":"country.9066292634018400","short_code":"at","wikidata":"Q40","text":"Austria"}]},{"id":"poi.3161095930306","type":"Feature","place_type":["poi"],"relevance":1,"properties":{"landmark":true,"address":"Maysedergasse 181","category":"nightclub, club, night club, disco"},"text":"Vienna Millionaire VVIP Club  +43 1 22100000 Maysedergasse 181","place_name":"Vienna Millionaire VVIP Club +43 1 22100000 Maysedergasse 181, Maysedergasse 181, Innere Stadt, Wien 1010, Austria","matching_text":"1010 Vienna","matching_place_name":"1010 Vienna, Maysedergasse 181, Innere Stadt, Wien 1010, Austria","center":[16.369286,48.204258],"geometry":{"coordinates":[16.369286,48.204258],"type":"Point"},"context":[{"id":"postcode.13989918056853140","text":"1010"},{"id":"place.13989918055915290","wikidata":"Q267329","text":"Innere Stadt"},{"id":"region.13927340704912510","short_code":"AT-9","wikidata":"Q1741","text":"Wien"},{"id":"country.9066292634018400","short_code":"at","wikidata":"Q40","text":"Austria"}]}],"attribution":"NOTICE: © 2019 Mapbox and its suppliers. All rights reserved. Use of this data is subject to the Mapbox Terms of Service (https://www.mapbox.com/about/maps/). This response and the information it contains may not be retained. POI(s) provided by Foursquare."}')
            ]),
        ]))->setOptions(['country' => 'at'])->find('1010');

        $this->assertSame('https://api.mapbox.com/geocoding/v5/mapbox.places/1010.json?access_token=pk.hd5FuVYvSRnJwzSQ2LJyyFQSWXuJEN5wTzgtGFcgxpWxRrWtATeQYLEuJxnPnqXAMZ.Or19S7KmYPHW8YjRz82v6g&country=at', (string)$this->mapBox->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Innere Stadt',
            'municipality' => null,
            'province' => 'Wien',
            'latitude' => 48.21,
            'longitude' => 16.37
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_an_invalid_postal_code()
    {
        $address = $this->mapBox->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"type":"FeatureCollection","query":["zeroresults"],"features":[],"attribution":"NOTICE: © 2019 Mapbox and its suppliers. All rights reserved. Use of this data is subject to the Mapbox Terms of Service (https://www.mapbox.com/about/maps/). This response and the information it contains may not be retained. POI(s) provided by Foursquare."}')
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

        $this->mapBox->findByPostcodeAndHouseNumber('1118CP', '202');
    }
}
