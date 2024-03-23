<?php

namespace nickurt\PostcodeApi\tests\Providers\en_US;

use Illuminate\Support\Facades\Http;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\en_US\Google;
use nickurt\PostcodeApi\tests\TestCase;

class GoogleTest extends TestCase
{
    /** @var Google */
    protected $google;

    public function setUp(): void
    {
        $this->google = (new Google)
            ->setRequestUrl('https://maps.googleapis.com/maps/api/geocode/json')
            ->setApiKey('Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie');
    }

    public function test_it_can_get_the_default_config_values_for_this_provider()
    {
        $this->assertSame('Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie', $this->google->getApiKey());
        $this->assertSame('https://maps.googleapis.com/maps/api/geocode/json', $this->google->getRequestUrl());
    }

    public function test_it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        Http::fake(['https://maps.googleapis.com/maps/api/geocode/json?address=92270&key=Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie' => Http::response('{"results":[{"address_components":[{"long_name":"92270","short_name":"92270","types":["postal_code"]},{"long_name":"Rancho Mirage","short_name":"Rancho Mirage","types":["locality","political"]},{"long_name":"Riverside County","short_name":"Riverside County","types":["administrative_area_level_2","political"]},{"long_name":"Californië","short_name":"CA","types":["administrative_area_level_1","political"]},{"long_name":"Verenigde Staten","short_name":"US","types":["country","political"]}],"formatted_address":"Rancho Mirage, Californië 92270, Verenigde Staten","geometry":{"bounds":{"northeast":{"lat":33.826022,"lng":-116.3881649},"southwest":{"lat":33.713622,"lng":-116.4779241}},"location":{"lat":33.7694489,"lng":-116.431192},"location_type":"APPROXIMATE","viewport":{"northeast":{"lat":33.826022,"lng":-116.3881649},"southwest":{"lat":33.713622,"lng":-116.4779241}}},"place_id":"ChIJOdHx3mD92oARzfjstDdtCYo","types":["postal_code"]}],"status":"OK"}')]);

        $address = $this->google->find('92270');

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

    public function test_it_can_get_the_correct_values_for_find_a_valid_postal_code2()
    {
        Http::fake(['https://maps.googleapis.com/maps/api/geocode/json?address=1118CP&key=Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie' => Http::response('{"results":[{"address_components":[{"long_name":"1118 CP","short_name":"1118 CP","types":["postal_code"]},{"long_name":"Schiphol","short_name":"Schiphol","types":["locality","political"]},{"long_name":"Haarlemmermeer","short_name":"Haarlemmermeer","types":["administrative_area_level_2","political"]},{"long_name":"Noord-Holland","short_name":"NH","types":["administrative_area_level_1","political"]},{"long_name":"Nederland","short_name":"NL","types":["country","political"]}],"formatted_address":"1118 CP Schiphol, Nederland","geometry":{"bounds":{"northeast":{"lat":52.3191141,"lng":4.768964},"southwest":{"lat":52.3032324,"lng":4.744388499999999}},"location":{"lat":52.3044099,"lng":4.7506488},"location_type":"APPROXIMATE","viewport":{"northeast":{"lat":52.3191141,"lng":4.768964},"southwest":{"lat":52.3032324,"lng":4.744388499999999}}},"place_id":"ChIJhUY2ydTgxUcRRa2W8lEPQkc","types":["postal_code"]}],"status":"OK"}')]);

        $address = $this->google->find('1118CP');

        $this->assertSame('Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie', $this->google->getApiKey());
        $this->assertSame('https://maps.googleapis.com/maps/api/geocode/json?address=1118CP&key=Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie', $this->google->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Schiphol',
            'municipality' => 'Haarlemmermeer',
            'province' => 'Noord-Holland',
            'latitude' => 52.3044099,
            'longitude' => 4.7506488,
        ], $address->toArray());
    }

    public function test_it_can_get_the_correct_values_for_find_a_valid_postal_code3()
    {
        Http::fake(['https://maps.googleapis.com/maps/api/geocode/json?address=SW1A1AA&key=Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie' => Http::response('{"results":[{"address_components":[{"long_name":"SW1A 1AA","short_name":"SW1A 1AA","types":["postal_code"]},{"long_name":"Londen","short_name":"Londen","types":["postal_town"]},{"long_name":"Groot-Londen","short_name":"Groot-Londen","types":["administrative_area_level_2","political"]},{"long_name":"Engeland","short_name":"Engeland","types":["administrative_area_level_1","political"]},{"long_name":"Verenigd Koninkrijk","short_name":"GB","types":["country","political"]}],"formatted_address":"Londen SW1A 1AA, Verenigd Koninkrijk","geometry":{"bounds":{"northeast":{"lat":51.5069575,"lng":-0.1385996},"southwest":{"lat":51.498598,"lng":-0.1516555}},"location":{"lat":51.502436,"lng":-0.1445783},"location_type":"APPROXIMATE","viewport":{"northeast":{"lat":51.5069575,"lng":-0.1385996},"southwest":{"lat":51.498598,"lng":-0.1516555}}},"place_id":"ChIJ1bidZScFdkgRqR6QyL-kxcA","types":["postal_code"]}],"status":"OK"}')]);

        $address = $this->google->find('SW1A1AA');

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

    public function test_it_can_get_the_correct_values_for_find_a_valid_postal_code4()
    {
        Http::fake(['https://maps.googleapis.com/maps/api/geocode/json?address=3066&key=Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie' => Http::response('{"results":[{"address_components":[{"long_name":"3066","short_name":"3066","types":["postal_code"]},{"long_name":"Collingwood North","short_name":"Collingwood North","types":["locality","political"]},{"long_name":"City of Yarra","short_name":"Yarra","types":["administrative_area_level_2","political"]},{"long_name":"Victoria","short_name":"VIC","types":["administrative_area_level_1","political"]},{"long_name":"Australië","short_name":"AU","types":["country","political"]}],"formatted_address":"Collingwood North VIC 3066, Australië","geometry":{"bounds":{"northeast":{"lat":-37.793896,"lng":144.9937469},"southwest":{"lat":-37.8098568,"lng":144.9825529}},"location":{"lat":-37.8009595,"lng":144.9873447},"location_type":"APPROXIMATE","viewport":{"northeast":{"lat":-37.793896,"lng":144.9937469},"southwest":{"lat":-37.8098568,"lng":144.9825529}}},"place_id":"ChIJrUX0neFC1moRkDQuRnhWBBw","postcode_localities":["Collingwood","Collingwood North"],"types":["postal_code"]}],"status":"OK"}')]);

        $address = $this->google->find('3066');

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

    public function test_it_can_get_the_correct_values_for_find_a_valid_postal_code5()
    {
        Http::fake(['https://maps.googleapis.com/maps/api/geocode/json?address=75007&key=Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie' => Http::response('{"results":[{"address_components":[{"long_name":"75007","short_name":"75007","types":["postal_code"]},{"long_name":"Parijs","short_name":"Parijs","types":["locality","political"]},{"long_name":"Parijs","short_name":"Parijs","types":["administrative_area_level_2","political"]},{"long_name":"Île-de-France","short_name":"IDF","types":["administrative_area_level_1","political"]},{"long_name":"Frankrijk","short_name":"FR","types":["country","political"]}],"formatted_address":"75007 Parijs, Frankrijk","geometry":{"bounds":{"northeast":{"lat":48.8637587,"lng":2.3332731},"southwest":{"lat":48.845927,"lng":2.2898664}},"location":{"lat":48.85433450000001,"lng":2.3134029},"location_type":"APPROXIMATE","viewport":{"northeast":{"lat":48.8637587,"lng":2.3332731},"southwest":{"lat":48.845927,"lng":2.2898664}}},"place_id":"ChIJWWRTZChw5kcRYFHY4caCCxw","types":["postal_code"]}],"status":"OK"}')]);

        $address = $this->google->find('75007');

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

    public function test_it_can_get_the_correct_values_for_find_a_valid_postal_code6()
    {
        Http::fake(['https://maps.googleapis.com/maps/api/geocode/json?address=1000&key=Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie' => Http::response('{"results":[{"address_components":[{"long_name":"1000","short_name":"1000","types":["postal_code"]},{"long_name":"Brussel","short_name":"Brussel","types":["locality","political"]},{"long_name":"Brussels Hoofdstedelijk Gewest","short_name":"Brussels Hoofdstedelijk Gewest","types":["administrative_area_level_1","political"]},{"long_name":"België","short_name":"BE","types":["country","political"]}],"formatted_address":"1000 Brussel, België","geometry":{"bounds":{"northeast":{"lat":50.8838089,"lng":4.4013462},"southwest":{"lat":50.7960624,"lng":4.3355197}},"location":{"lat":50.8427501,"lng":4.3515499},"location_type":"APPROXIMATE","viewport":{"northeast":{"lat":50.8838089,"lng":4.4013462},"southwest":{"lat":50.7960624,"lng":4.3355197}}},"place_id":"ChIJX6UHPofEw0cRXd0IVgg8wQA","types":["postal_code"]}],"status":"OK"}')]);

        $address = $this->google->find('1000');

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

    public function test_it_can_get_the_correct_values_for_find_a_valid_postal_code7()
    {
        Http::fake(['https://maps.googleapis.com/maps/api/geocode/json?address=10115&key=Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie' => Http::response('{"results":[{"address_components":[{"long_name":"10115","short_name":"10115","types":["postal_code"]},{"long_name":"Mitte","short_name":"Mitte","types":["political","sublocality","sublocality_level_1"]},{"long_name":"Berlijn","short_name":"Berlijn","types":["locality","political"]},{"long_name":"Berlijn","short_name":"Berlijn","types":["administrative_area_level_1","political"]},{"long_name":"Duitsland","short_name":"DE","types":["country","political"]}],"formatted_address":"10115 Berlijn, Duitsland","geometry":{"bounds":{"northeast":{"lat":52.5400381,"lng":13.401033},"southwest":{"lat":52.52368999999999,"lng":13.3657661}},"location":{"lat":52.532614,"lng":13.3777036},"location_type":"APPROXIMATE","viewport":{"northeast":{"lat":52.5400381,"lng":13.401033},"southwest":{"lat":52.52368999999999,"lng":13.3657661}}},"place_id":"ChIJSwrO4exRqEcRkNA9lUkgIRw","types":["postal_code"]}],"status":"OK"}')]);

        $address = $this->google->find('10115');

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

    public function test_it_can_get_the_correct_values_for_find_a_valid_postal_code8()
    {
        Http::fake(['https://maps.googleapis.com/maps/api/geocode/json?address=1010&key=Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie' => Http::response('{"results":[{"address_components":[{"long_name":"1010","short_name":"1010","types":["postal_code"]},{"long_name":"Innere Stadt","short_name":"Innere Stadt","types":["political","sublocality","sublocality_level_1"]},{"long_name":"Wenen","short_name":"Wenen","types":["locality","political"]},{"long_name":"Wenen","short_name":"Wenen","types":["administrative_area_level_1","political"]},{"long_name":"Oostenrijk","short_name":"AT","types":["country","political"]}],"formatted_address":"1010 Wenen, Oostenrijk","geometry":{"bounds":{"northeast":{"lat":48.2185876,"lng":16.3853131},"southwest":{"lat":48.1992606,"lng":16.3552218}},"location":{"lat":48.2082647,"lng":16.3739206},"location_type":"APPROXIMATE","viewport":{"northeast":{"lat":48.2185876,"lng":16.3853131},"southwest":{"lat":48.1992606,"lng":16.3552218}}},"place_id":"ChIJOe-7qAcHbUcR-aPvvFaWIkg","types":["postal_code"]}],"status":"OK"}')]);

        $address = $this->google->find('1010');

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

    public function test_it_can_get_the_correct_values_for_find_an_invalid_postal_code()
    {
        Http::fake(['https://maps.googleapis.com/maps/api/geocode/json?address=zeroresults&key=Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie' => Http::response('{"results":[],"status":"ZERO_RESULTS"}')]);

        $address = $this->google->find('zeroresults');

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

    public function test_it_can_get_the_correct_values_for_find_by_postcode_and_house_number_a_valid_postal_code()
    {
        Http::fake(['https://maps.googleapis.com/maps/api/geocode/json?address=92270+1&key=Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie' => Http::response('{"results":[{"address_components":[{"long_name":"1","short_name":"1","types":["street_number"]},{"long_name":"Duke Drive","short_name":"Duke Dr","types":["route"]},{"long_name":"Rancho Mirage","short_name":"Rancho Mirage","types":["locality","political"]},{"long_name":"Riverside County","short_name":"Riverside County","types":["administrative_area_level_2","political"]},{"long_name":"California","short_name":"CA","types":["administrative_area_level_1","political"]},{"long_name":"Verenigde Staten","short_name":"US","types":["country","political"]},{"long_name":"92270","short_name":"92270","types":["postal_code"]}],"formatted_address":"1 Duke Dr, Rancho Mirage, CA 92270, Verenigde Staten","geometry":{"location":{"lat":33.7647421,"lng":-116.4197943},"location_type":"ROOFTOP","viewport":{"northeast":{"lat":33.7660910802915,"lng":-116.4184453197085},"southwest":{"lat":33.7633931197085,"lng":-116.4211432802915}}},"place_id":"ChIJf-fu0oEC24ARSlZsJpuGfXQ","plus_code":{"compound_code":"QH7J+V3 Rancho Mirage, California, Verenigde Staten","global_code":"8555QH7J+V3"},"types":["establishment","point_of_interest"]}],"status":"OK"}')]);

        $address = $this->google->findByPostcodeAndHouseNumber('92270', 1);

        $this->assertSame('Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie', $this->google->getApiKey());
        $this->assertSame('https://maps.googleapis.com/maps/api/geocode/json?address=92270+1&key=Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie', $this->google->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => 'Duke Drive',
            'house_no' => '1',
            'town' => 'Rancho Mirage',
            'municipality' => 'Riverside County',
            'province' => 'California',
            'latitude' => 33.7647421,
            'longitude' => -116.4197943,
        ], $address->toArray());
    }

    public function test_it_can_get_the_correct_values_for_find_by_postcode_and_house_number_a_valid_postal_code2()
    {
        Http::fake(['https://maps.googleapis.com/maps/api/geocode/json?address=1118CP+202&key=Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie' => Http::response('{"results":[{"address_components":[{"long_name":"Amsterdam Airport Schiphol","short_name":"Amsterdam Airport Schiphol","types":["airport","establishment","point_of_interest","political"]},{"long_name":"202","short_name":"202","types":["street_number"]},{"long_name":"Evert van de Beekstraat","short_name":"Evert van de Beekstraat","types":["route"]},{"long_name":"Schiphol","short_name":"Schiphol","types":["locality","political"]},{"long_name":"Haarlemmermeer","short_name":"Haarlemmermeer","types":["administrative_area_level_2","political"]},{"long_name":"Noord-Holland","short_name":"NH","types":["administrative_area_level_1","political"]},{"long_name":"Nederland","short_name":"NL","types":["country","political"]},{"long_name":"1118 CP","short_name":"1118 CP","types":["postal_code"]}],"formatted_address":"Amsterdam Airport Schiphol (AMS), Evert van de Beekstraat 202, 1118 CP Schiphol, Nederland","geometry":{"location":{"lat":52.3105386,"lng":4.7682744},"location_type":"ROOFTOP","viewport":{"northeast":{"lat":52.3118875802915,"lng":4.769623380291502},"southwest":{"lat":52.3091896197085,"lng":4.766925419708498}}},"partial_match":true,"place_id":"ChIJLRb94DThxUcRiPHO8YMV1cc","plus_code":{"compound_code":"8Q69+68 Schiphol, Nederland","global_code":"9F468Q69+68"},"types":["airport","establishment","point_of_interest","political"]}],"status":"OK"}')]);

        $address = $this->google->findByPostcodeAndHouseNumber('1118CP', 202);

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

    public function test_it_can_get_the_correct_values_for_find_by_postcode_and_house_number_a_valid_postal_code3()
    {
        Http::fake(['https://maps.googleapis.com/maps/api/geocode/json?address=SW1A2AA+10&key=Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie' => Http::response('{"results":[{"address_components":[{"long_name":"10","short_name":"10","types":["street_number"]},{"long_name":"Downing Street","short_name":"Downing St","types":["route"]},{"long_name":"Westminster","short_name":"Westminster","types":["neighborhood","political"]},{"long_name":"London","short_name":"London","types":["postal_town"]},{"long_name":"Greater London","short_name":"Greater London","types":["administrative_area_level_2","political"]},{"long_name":"England","short_name":"England","types":["administrative_area_level_1","political"]},{"long_name":"Verenigd Koninkrijk","short_name":"GB","types":["country","political"]},{"long_name":"SW1A 2AA","short_name":"SW1A 2AA","types":["postal_code"]}],"formatted_address":"10 Downing St, Westminster, London SW1A 2AA, Verenigd Koninkrijk","geometry":{"location":{"lat":51.5033635,"lng":-0.1276248},"location_type":"ROOFTOP","viewport":{"northeast":{"lat":51.5047124802915,"lng":-0.126275819708498},"southwest":{"lat":51.5020145197085,"lng":-0.128973780291502}}},"place_id":"ChIJRxzRQcUEdkgRGVaKyzmkgvg","plus_code":{"compound_code":"GV3C+8X Westminster, London, Verenigd Koninkrijk","global_code":"9C3XGV3C+8X"},"types":["establishment","point_of_interest","tourist_attraction"]}],"status":"OK"}')]);

        $address = $this->google->findByPostcodeAndHouseNumber('SW1A2AA', 10);

        $this->assertSame('Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie', $this->google->getApiKey());
        $this->assertSame('https://maps.googleapis.com/maps/api/geocode/json?address=SW1A2AA+10&key=Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie', $this->google->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => 'Downing Street',
            'house_no' => '10',
            'town' => 'London',
            'municipality' => 'Greater London',
            'province' => 'England',
            'latitude' => 51.5033635,
            'longitude' => -0.1276248,
        ], $address->toArray());
    }

    public function test_it_can_get_the_correct_values_for_find_by_postcode_and_house_number_a_valid_postal_code4()
    {
        Http::fake(['https://maps.googleapis.com/maps/api/geocode/json?address=3066+107&key=Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie' => Http::response('{"results":[{"address_components":[{"long_name":"107","short_name":"107","types":["street_number"]},{"long_name":"Keele Street","short_name":"Keele St","types":["route"]},{"long_name":"Collingwood","short_name":"Collingwood","types":["locality","political"]},{"long_name":"City of Yarra","short_name":"Yarra","types":["administrative_area_level_2","political"]},{"long_name":"Victoria","short_name":"VIC","types":["administrative_area_level_1","political"]},{"long_name":"Australië","short_name":"AU","types":["country","political"]},{"long_name":"3066","short_name":"3066","types":["postal_code"]}],"formatted_address":"107 Keele St, Collingwood VIC 3066, Australië","geometry":{"location":{"lat":-37.797559,"lng":144.990143},"location_type":"ROOFTOP","viewport":{"northeast":{"lat":-37.7962100197085,"lng":144.9914919802915},"southwest":{"lat":-37.7989079802915,"lng":144.9887940197085}}},"place_id":"ChIJ76UukxtD1moRCWqnTrEtEXU","plus_code":{"compound_code":"6X2R+X3 Collingwood, Victoria, Australië","global_code":"4RJ66X2R+X3"},"types":["street_address"]}],"status":"OK"}')]);

        $address = $this->google->findByPostcodeAndHouseNumber('3066', 107);

        $this->assertSame('Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie', $this->google->getApiKey());
        $this->assertSame('https://maps.googleapis.com/maps/api/geocode/json?address=3066+107&key=Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie', $this->google->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => 'Keele Street',
            'house_no' => '107',
            'town' => 'Collingwood',
            'municipality' => 'City of Yarra',
            'province' => 'Victoria',
            'latitude' => -37.797559,
            'longitude' => 144.990143,
        ], $address->toArray());
    }

    public function test_it_can_get_the_correct_values_for_find_by_postcode_and_house_number_a_valid_postal_code5()
    {
        Http::fake(['https://maps.googleapis.com/maps/api/geocode/json?address=75007+2&key=Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie' => Http::response('{"results":[{"address_components":[{"long_name":"2","short_name":"2","types":["street_number"]},{"long_name":"Avenue de Suffren","short_name":"Avenue de Suffren","types":["route"]},{"long_name":"Paris","short_name":"Paris","types":["locality","political"]},{"long_name":"Arrondissement de Paris","short_name":"Arrondissement de Paris","types":["administrative_area_level_2","political"]},{"long_name":"Île-de-France","short_name":"IDF","types":["administrative_area_level_1","political"]},{"long_name":"Frankrijk","short_name":"FR","types":["country","political"]},{"long_name":"75007","short_name":"75007","types":["postal_code"]}],"formatted_address":"2 Avenue de Suffren, 75007 Paris, Frankrijk","geometry":{"location":{"lat":48.8564295,"lng":2.2916603},"location_type":"ROOFTOP","viewport":{"northeast":{"lat":48.8577784802915,"lng":2.293009280291502},"southwest":{"lat":48.8550805197085,"lng":2.290311319708498}}},"place_id":"ChIJL9VLmh1w5kcRxPIaRtAwerM","plus_code":{"compound_code":"V74R+HM Parijs, Frankrijk","global_code":"8FW4V74R+HM"},"types":["establishment","point_of_interest"]}],"status":"OK"}')]);

        $address = $this->google->findByPostcodeAndHouseNumber('75007', 2);

        $this->assertSame('Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie', $this->google->getApiKey());
        $this->assertSame('https://maps.googleapis.com/maps/api/geocode/json?address=75007+2&key=Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie', $this->google->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => 'Avenue de Suffren',
            'house_no' => '2',
            'town' => 'Paris',
            'municipality' => 'Arrondissement de Paris',
            'province' => 'Île-de-France',
            'latitude' => 48.8564295,
            'longitude' => 2.2916603,
        ], $address->toArray());
    }

    public function test_it_can_get_the_correct_values_for_find_by_postcode_and_house_number_a_valid_postal_code6()
    {
        Http::fake(['https://maps.googleapis.com/maps/api/geocode/json?address=1000+6&key=Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie' => Http::response('{"results":[{"address_components":[{"long_name":"6","short_name":"6","types":["street_number"]},{"long_name":"Anspachlaan","short_name":"Anspachlaan","types":["route"]},{"long_name":"Brussel","short_name":"Brussel","types":["locality","political"]},{"long_name":"Brussels Hoofdstedelijk Gewest","short_name":"Brussels Hoofdstedelijk Gewest","types":["administrative_area_level_1","political"]},{"long_name":"België","short_name":"BE","types":["country","political"]},{"long_name":"1000","short_name":"1000","types":["postal_code"]}],"formatted_address":"Anspachlaan 6, 1000 Brussel, België","geometry":{"location":{"lat":50.8505336,"lng":4.3522918},"location_type":"ROOFTOP","viewport":{"northeast":{"lat":50.8518825802915,"lng":4.353640780291502},"southwest":{"lat":50.8491846197085,"lng":4.350942819708497}}},"place_id":"ChIJV5DhKYfDw0cRHFxuaqlAtiw","plus_code":{"compound_code":"V922+6W Brussels Hoofdstedelijk Gewest, België","global_code":"9F26V922+6W"},"types":["street_address"]}],"status":"OK"}')]);

        $address = $this->google->findByPostcodeAndHouseNumber('1000', 6);

        $this->assertSame('Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie', $this->google->getApiKey());
        $this->assertSame('https://maps.googleapis.com/maps/api/geocode/json?address=1000+6&key=Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie', $this->google->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => 'Anspachlaan',
            'house_no' => '6',
            'town' => 'Brussel',
            'municipality' => null,
            'province' => 'Brussels Hoofdstedelijk Gewest',
            'latitude' => 50.8505336,
            'longitude' => 4.3522918,
        ], $address->toArray());
    }

    public function test_it_can_get_the_correct_values_for_find_by_postcode_and_house_number_a_valid_postal_code7()
    {
        Http::fake(['https://maps.googleapis.com/maps/api/geocode/json?address=10115+1&key=Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie' => Http::response('{"results":[{"address_components":[{"long_name":"1","short_name":"1","types":["street_number"]},{"long_name":"Borsigstraße","short_name":"Borsigstraße","types":["route"]},{"long_name":"Mitte","short_name":"Mitte","types":["political","sublocality","sublocality_level_1"]},{"long_name":"Berlin","short_name":"Berlin","types":["locality","political"]},{"long_name":"Berlin","short_name":"Berlin","types":["administrative_area_level_1","political"]},{"long_name":"Duitsland","short_name":"DE","types":["country","political"]},{"long_name":"10115","short_name":"10115","types":["postal_code"]}],"formatted_address":"Borsigstraße 1, 10115 Berlin, Duitsland","geometry":{"location":{"lat":52.52839729999999,"lng":13.3912527},"location_type":"ROOFTOP","viewport":{"northeast":{"lat":52.52974628029149,"lng":13.3926016802915},"southwest":{"lat":52.52704831970849,"lng":13.3899037197085}}},"place_id":"ChIJYYO7Ku9RqEcR8cykn63l7q8","plus_code":{"compound_code":"G9HR+9G Berlijn, Duitsland","global_code":"9F4MG9HR+9G"},"types":["establishment","lodging","point_of_interest"]}],"status":"OK"}')]);

        $address = $this->google->findByPostcodeAndHouseNumber('10115', 1);

        $this->assertSame('Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie', $this->google->getApiKey());
        $this->assertSame('https://maps.googleapis.com/maps/api/geocode/json?address=10115+1&key=Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie', $this->google->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => 'Borsigstraße',
            'house_no' => '1',
            'town' => 'Berlin',
            'municipality' => null,
            'province' => 'Berlin',
            'latitude' => 52.52839729999999,
            'longitude' => 13.3912527,
        ], $address->toArray());
    }

    public function test_it_can_get_the_correct_values_for_find_by_postcode_and_house_number_a_valid_postal_code8()
    {
        Http::fake(['https://maps.googleapis.com/maps/api/geocode/json?address=1010+2&key=Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie' => Http::response('{"results":[{"address_components":[{"long_name":"Köllnerhofgasse","short_name":"Köllnerhofgasse","types":["route"]},{"long_name":"Innere Stadt","short_name":"Innere Stadt","types":["political","sublocality","sublocality_level_1"]},{"long_name":"Wien","short_name":"Wien","types":["locality","political"]},{"long_name":"Wien","short_name":"Wien","types":["administrative_area_level_1","political"]},{"long_name":"Oostenrijk","short_name":"AT","types":["country","political"]},{"long_name":"1010","short_name":"1010","types":["postal_code"]}],"formatted_address":"Köllnerhofgasse, 1010 Wien, Oostenrijk","geometry":{"location":{"lat":48.2104317,"lng":16.3758234},"location_type":"GEOMETRIC_CENTER","viewport":{"northeast":{"lat":48.2117806802915,"lng":16.3771723802915},"southwest":{"lat":48.2090827197085,"lng":16.37447441970849}}},"place_id":"ChIJcU7G1aEHbUcR1GMvpoaZt9M","types":["establishment","point_of_interest"]}],"status":"OK"}')]);

        $address = $this->google->findByPostcodeAndHouseNumber('1010', 2);

        $this->assertSame('Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie', $this->google->getApiKey());
        $this->assertSame('https://maps.googleapis.com/maps/api/geocode/json?address=1010+2&key=Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie', $this->google->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => 'Köllnerhofgasse',
            'house_no' => null,
            'town' => 'Wien',
            'municipality' => null,
            'province' => 'Wien',
            'latitude' => 48.2104317,
            'longitude' => 16.3758234,
        ], $address->toArray());
    }

    public function test_it_can_get_the_correct_values_for_find_by_postcode_and_house_number_an_invalid_postal_code()
    {
        Http::fake(['https://maps.googleapis.com/maps/api/geocode/json?address=zeroresults+zeroresults&key=Wrai_nwnetck2jlztk6vgwjaysrzbkzuvhhaaie' => Http::response('{"results":[],"status":"ZERO_RESULTS"}')]);

        $address = $this->google->findByPostcodeAndHouseNumber('zeroresults', 'zeroresults');

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

    public function tearDown(): void
    {
        $this->clearExistingFakes();

        parent::tearDown();
    }
}
