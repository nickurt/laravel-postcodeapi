<?php

namespace nickurt\PostcodeApi\tests\Providers\en_US;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Exception\NotSupportedException;
use nickurt\PostcodeApi\Providers\en_US\Google;
use nickurt\PostcodeApi\tests\Providers\BaseProviderTest;

class GoogleTest extends BaseProviderTest
{
    /** @var Google */
    protected $google;

    public function setUp(): void
    {
        $this->google = (new Google)
            ->setRequestUrl('https://maps.googleapis.com/maps/api/geocode/json')
            ->setApiKey('Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie');
    }

    /** @test */
    public function it_can_get_the_default_config_values_for_this_provider()
    {
        $this->assertSame('Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie', $this->google->getApiKey());
        $this->assertSame('https://maps.googleapis.com/maps/api/geocode/json', $this->google->getRequestUrl());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        $address = $this->google->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"results":[{"address_components":[{"long_name":"92270","short_name":"92270","types":["postal_code"]},{"long_name":"Rancho Mirage","short_name":"Rancho Mirage","types":["locality","political"]},{"long_name":"Riverside County","short_name":"Riverside County","types":["administrative_area_level_2","political"]},{"long_name":"Californië","short_name":"CA","types":["administrative_area_level_1","political"]},{"long_name":"Verenigde Staten","short_name":"US","types":["country","political"]}],"formatted_address":"Rancho Mirage, Californië 92270, Verenigde Staten","geometry":{"bounds":{"northeast":{"lat":33.826022,"lng":-116.3881649},"southwest":{"lat":33.713622,"lng":-116.4779241}},"location":{"lat":33.7694489,"lng":-116.431192},"location_type":"APPROXIMATE","viewport":{"northeast":{"lat":33.826022,"lng":-116.3881649},"southwest":{"lat":33.713622,"lng":-116.4779241}}},"place_id":"ChIJOdHx3mD92oARzfjstDdtCYo","types":["postal_code"]}],"status":"OK"}'),
            ]),
        ]))->find('92270');

        $this->assertSame('Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie', $this->google->getApiKey());
        $this->assertSame('https://maps.googleapis.com/maps/api/geocode/json?address=92270&key=Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie', $this->google->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Rancho Mirage',
            'municipality' => 'Riverside County',
            'province' => 'Californië',
            'latitude' => 33.7694489,
            'longitude' => -116.431192,
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code2()
    {
        $address = $this->google->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"results":[{"address_components":[{"long_name":"Amsterdam Airport Schiphol","short_name":"Amsterdam Airport Schiphol","types":["airport","establishment","point_of_interest","political"]},{"long_name":"202","short_name":"202","types":["street_number"]},{"long_name":"Evert van de Beekstraat","short_name":"Evert van de Beekstraat","types":["route"]},{"long_name":"Schiphol","short_name":"Schiphol","types":["locality","political"]},{"long_name":"Haarlemmermeer","short_name":"Haarlemmermeer","types":["administrative_area_level_2","political"]},{"long_name":"Noord-Holland","short_name":"NH","types":["administrative_area_level_1","political"]},{"long_name":"Nederland","short_name":"NL","types":["country","political"]},{"long_name":"1118 CP","short_name":"1118 CP","types":["postal_code"]}],"formatted_address":"Amsterdam Airport Schiphol (AMS), Evert van de Beekstraat 202, 1118 CP Schiphol, Nederland","geometry":{"location":{"lat":52.3105386,"lng":4.7682744},"location_type":"ROOFTOP","viewport":{"northeast":{"lat":52.3118875802915,"lng":4.769623380291502},"southwest":{"lat":52.3091896197085,"lng":4.766925419708498}}},"partial_match":true,"place_id":"ChIJLRb94DThxUcRiPHO8YMV1cc","plus_code":{"compound_code":"8Q69+68 Schiphol, Nederland","global_code":"9F468Q69+68"},"types":["airport","establishment","point_of_interest","political"]}],"status":"OK"}'),
            ]),
        ]))->find('1118CP+202');

        $this->assertSame('Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie', $this->google->getApiKey());
        $this->assertSame('https://maps.googleapis.com/maps/api/geocode/json?address=1118CP+202&key=Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie', $this->google->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => 'Evert van de Beekstraat',
            'house_no' => '202',
            'town' => 'Schiphol',
            'municipality' => 'Haarlemmermeer',
            'province' => 'Noord-Holland',
            'latitude' => 52.3105386,
            'longitude' => 4.7682744,
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code3()
    {
        $address = $this->google->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"results":[{"address_components":[{"long_name":"SW1A 1AA","short_name":"SW1A 1AA","types":["postal_code"]},{"long_name":"Londen","short_name":"Londen","types":["postal_town"]},{"long_name":"Groot-Londen","short_name":"Groot-Londen","types":["administrative_area_level_2","political"]},{"long_name":"Engeland","short_name":"Engeland","types":["administrative_area_level_1","political"]},{"long_name":"Verenigd Koninkrijk","short_name":"GB","types":["country","political"]}],"formatted_address":"Londen SW1A 1AA, Verenigd Koninkrijk","geometry":{"bounds":{"northeast":{"lat":51.5069575,"lng":-0.1385996},"southwest":{"lat":51.498598,"lng":-0.1516555}},"location":{"lat":51.502436,"lng":-0.1445783},"location_type":"APPROXIMATE","viewport":{"northeast":{"lat":51.5069575,"lng":-0.1385996},"southwest":{"lat":51.498598,"lng":-0.1516555}}},"place_id":"ChIJ1bidZScFdkgRqR6QyL-kxcA","types":["postal_code"]}],"status":"OK"}'),
            ]),
        ]))->find('SW1A1AA');

        $this->assertSame('Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie', $this->google->getApiKey());
        $this->assertSame('https://maps.googleapis.com/maps/api/geocode/json?address=SW1A1AA&key=Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie', $this->google->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Londen',
            'municipality' => 'Groot-Londen',
            'province' => 'Engeland',
            'latitude' => 51.502436,
            'longitude' => -0.1445783,
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code4()
    {
        $address = $this->google->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"results":[{"address_components":[{"long_name":"3066","short_name":"3066","types":["postal_code"]},{"long_name":"Collingwood North","short_name":"Collingwood North","types":["locality","political"]},{"long_name":"City of Yarra","short_name":"Yarra","types":["administrative_area_level_2","political"]},{"long_name":"Victoria","short_name":"VIC","types":["administrative_area_level_1","political"]},{"long_name":"Australië","short_name":"AU","types":["country","political"]}],"formatted_address":"Collingwood North VIC 3066, Australië","geometry":{"bounds":{"northeast":{"lat":-37.793896,"lng":144.9937469},"southwest":{"lat":-37.8098568,"lng":144.9825529}},"location":{"lat":-37.8009595,"lng":144.9873447},"location_type":"APPROXIMATE","viewport":{"northeast":{"lat":-37.793896,"lng":144.9937469},"southwest":{"lat":-37.8098568,"lng":144.9825529}}},"place_id":"ChIJrUX0neFC1moRkDQuRnhWBBw","postcode_localities":["Collingwood","Collingwood North"],"types":["postal_code"]}],"status":"OK"}'),
            ]),
        ]))->find('3066');

        $this->assertSame('Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie', $this->google->getApiKey());
        $this->assertSame('https://maps.googleapis.com/maps/api/geocode/json?address=3066&key=Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie', $this->google->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Collingwood North',
            'municipality' => 'City of Yarra',
            'province' => 'Victoria',
            'latitude' => -37.8009595,
            'longitude' => 144.9873447,
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code5()
    {
        $address = $this->google->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"results":[{"address_components":[{"long_name":"75007","short_name":"75007","types":["postal_code"]},{"long_name":"Parijs","short_name":"Parijs","types":["locality","political"]},{"long_name":"Parijs","short_name":"Parijs","types":["administrative_area_level_2","political"]},{"long_name":"Île-de-France","short_name":"Île-de-France","types":["administrative_area_level_1","political"]},{"long_name":"Frankrijk","short_name":"FR","types":["country","political"]}],"formatted_address":"75007 Parijs, Frankrijk","geometry":{"bounds":{"northeast":{"lat":48.8637587,"lng":2.3332731},"southwest":{"lat":48.845927,"lng":2.2898664}},"location":{"lat":48.85433450000001,"lng":2.3134029},"location_type":"APPROXIMATE","viewport":{"northeast":{"lat":48.8637587,"lng":2.3332731},"southwest":{"lat":48.845927,"lng":2.2898664}}},"place_id":"ChIJWWRTZChw5kcRYFHY4caCCxw","types":["postal_code"]}],"status":"OK"}'),
            ]),
        ]))->find('75007');

        $this->assertSame('Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie', $this->google->getApiKey());
        $this->assertSame('https://maps.googleapis.com/maps/api/geocode/json?address=75007&key=Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie', $this->google->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Parijs',
            'municipality' => 'Parijs',
            'province' => 'Île-de-France',
            'latitude' => 48.85433450000001,
            'longitude' => 2.3134029,
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code6()
    {
        $address = $this->google->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"results":[{"address_components":[{"long_name":"1000","short_name":"1000","types":["postal_code"]},{"long_name":"Brussel","short_name":"Brussel","types":["locality","political"]},{"long_name":"Brussels Hoofdstedelijk Gewest","short_name":"Brussels Hoofdstedelijk Gewest","types":["administrative_area_level_1","political"]},{"long_name":"België","short_name":"BE","types":["country","political"]}],"formatted_address":"1000 Brussel, België","geometry":{"bounds":{"northeast":{"lat":50.8838089,"lng":4.4013462},"southwest":{"lat":50.7960624,"lng":4.3355197}},"location":{"lat":50.8427501,"lng":4.3515499},"location_type":"APPROXIMATE","viewport":{"northeast":{"lat":50.8838089,"lng":4.4013462},"southwest":{"lat":50.7960624,"lng":4.3355197}}},"place_id":"ChIJX6UHPofEw0cRXd0IVgg8wQA","types":["postal_code"]}],"status":"OK"}'),
            ]),
        ]))->find('1000');

        $this->assertSame('Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie', $this->google->getApiKey());
        $this->assertSame('https://maps.googleapis.com/maps/api/geocode/json?address=1000&key=Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie', $this->google->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Brussel',
            'municipality' => null,
            'province' => 'Brussels Hoofdstedelijk Gewest',
            'latitude' => 50.8427501,
            'longitude' => 4.3515499,
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code7()
    {
        $address = $this->google->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"results":[{"address_components":[{"long_name":"10115","short_name":"10115","types":["postal_code"]},{"long_name":"Mitte","short_name":"Mitte","types":["political","sublocality","sublocality_level_1"]},{"long_name":"Berlijn","short_name":"Berlijn","types":["locality","political"]},{"long_name":"Berlijn","short_name":"Berlijn","types":["administrative_area_level_1","political"]},{"long_name":"Duitsland","short_name":"DE","types":["country","political"]}],"formatted_address":"10115 Berlijn, Duitsland","geometry":{"bounds":{"northeast":{"lat":52.5400381,"lng":13.401033},"southwest":{"lat":52.52368999999999,"lng":13.3657661}},"location":{"lat":52.532614,"lng":13.3777036},"location_type":"APPROXIMATE","viewport":{"northeast":{"lat":52.5400381,"lng":13.401033},"southwest":{"lat":52.52368999999999,"lng":13.3657661}}},"place_id":"ChIJSwrO4exRqEcRkNA9lUkgIRw","types":["postal_code"]}],"status":"OK"}'),
            ]),
        ]))->find('10115');

        $this->assertSame('Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie', $this->google->getApiKey());
        $this->assertSame('https://maps.googleapis.com/maps/api/geocode/json?address=10115&key=Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie', $this->google->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Berlijn',
            'municipality' => null,
            'province' => 'Berlijn',
            'latitude' => 52.532614,
            'longitude' => 13.3777036,
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code8()
    {
        $address = $this->google->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"results":[{"address_components":[{"long_name":"1010","short_name":"1010","types":["postal_code"]},{"long_name":"Innere Stadt","short_name":"Innere Stadt","types":["political","sublocality","sublocality_level_1"]},{"long_name":"Wenen","short_name":"Wenen","types":["locality","political"]},{"long_name":"Wenen","short_name":"Wenen","types":["administrative_area_level_1","political"]},{"long_name":"Oostenrijk","short_name":"AT","types":["country","political"]}],"formatted_address":"1010 Wenen, Oostenrijk","geometry":{"bounds":{"northeast":{"lat":48.2185876,"lng":16.3853131},"southwest":{"lat":48.1992606,"lng":16.3552218}},"location":{"lat":48.2082647,"lng":16.3739206},"location_type":"APPROXIMATE","viewport":{"northeast":{"lat":48.2185876,"lng":16.3853131},"southwest":{"lat":48.1992606,"lng":16.3552218}}},"place_id":"ChIJOe-7qAcHbUcR-aPvvFaWIkg","types":["postal_code"]}],"status":"OK"}'),
            ]),
        ]))->find('1010');

        $this->assertSame('Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie', $this->google->getApiKey());
        $this->assertSame('https://maps.googleapis.com/maps/api/geocode/json?address=1010&key=Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie', $this->google->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Wenen',
            'municipality' => null,
            'province' => 'Wenen',
            'latitude' => 48.2082647,
            'longitude' => 16.3739206,
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_an_invalid_postal_code()
    {
        $address = $this->google->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"results":[],"status":"ZERO_RESULTS"}'),
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
            'longitude' => null,
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_a_valid_postal_code()
    {
        $this->expectException(NotSupportedException::class);

        $this->google->findByPostcodeAndHouseNumber('1118CP', '202');
    }
}
