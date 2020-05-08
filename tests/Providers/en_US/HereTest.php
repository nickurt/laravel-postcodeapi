<?php

namespace nickurt\PostcodeApi\Tests\Providers\en_US;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Exception\NotSupportedException;
use nickurt\PostcodeApi\Providers\en_US\Here;
use nickurt\PostcodeApi\Tests\Providers\BaseProviderTest;

class HereTest extends BaseProviderTest
{
    /** @var Here */
    protected $here;

    public function setUp(): void
    {
        $this->here = (new Here)
            ->setRequestUrl('https://geocoder.api.here.com/6.2/geocode.json')
            ->setApiKey('Q28yv1juyWQexhHdoJ1P')
            ->setApiSecret('pJKdj-mUwxw1thw8EjCX9v');
    }

    /** @test */
    public function it_can_get_the_default_config_values_for_this_provider()
    {
        $this->assertSame('Q28yv1juyWQexhHdoJ1P', $this->here->getApiKey());
        $this->assertSame('pJKdj-mUwxw1thw8EjCX9v', $this->here->getApiSecret());
        $this->assertSame('https://geocoder.api.here.com/6.2/geocode.json', $this->here->getRequestUrl());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        $address = $this->here->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"Response":{"MetaInfo":{"Timestamp":"2019-08-04T11:54:52.054+0000"},"View":[{"_type":"SearchResultsViewType","ViewId":0,"Result":[{"Relevance":1.0,"MatchLevel":"houseNumber","MatchQuality":{"State":1.0,"Street":[1.0],"HouseNumber":1.0,"PostalCode":1.0},"MatchType":"pointAddress","Location":{"LocationId":"NT_fCLiZcIRSrsOwo2Gh19paB_0IzM3AD","LocationType":"address","DisplayPosition":{"Latitude":33.73865,"Longitude":-116.40715},"NavigationPosition":[{"Latitude":33.73868,"Longitude":-116.40809}],"MapView":{"TopLeft":{"Latitude":33.7397742,"Longitude":-116.4085018},"BottomRight":{"Latitude":33.7375258,"Longitude":-116.4057982}},"Address":{"Label":"42370 Bob Hope Dr, Rancho Mirage, CA 92270, United States","Country":"USA","State":"CA","County":"Riverside","City":"Rancho Mirage","Street":"Bob Hope Dr","HouseNumber":"42370","PostalCode":"92270","AdditionalData":[{"value":"United States","key":"CountryName"},{"value":"California","key":"StateName"},{"value":"Riverside","key":"CountyName"},{"value":"N","key":"PostalCodeType"}]}}}]}]}}')
            ]),
        ]))->setOptions(['housenumber' => '42370', 'state' => 'CA', 'street' => 'Bob Hope Drive'])->find('92270');

        $this->assertSame('https://geocoder.api.here.com/6.2/geocode.json?postalCode=92270&app_id=Q28yv1juyWQexhHdoJ1P&app_code=pJKdj-mUwxw1thw8EjCX9v&gen=9&housenumber=42370&state=CA&street=Bob+Hope+Drive', $this->here->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => 'Bob Hope Dr',
            'house_no' => '42370',
            'town' => 'Rancho Mirage',
            'municipality' => 'Riverside',
            'province' => 'CA',
            'latitude' => 33.73865,
            'longitude' => -116.40715
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code2()
    {
        $address = $this->here->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"Response":{"MetaInfo":{"Timestamp":"2019-08-04T11:48:07.728+0000"},"View":[{"_type":"SearchResultsViewType","ViewId":0,"Result":[{"Relevance":1.0,"MatchLevel":"postalCode","MatchQuality":{"PostalCode":1.0},"Location":{"LocationId":"NT_lTkqMCIIlwBQ83Oag.7hND","LocationType":"area","DisplayPosition":{"Latitude":52.30307,"Longitude":4.747},"NavigationPosition":[{"Latitude":52.30307,"Longitude":4.747}],"MapView":{"TopLeft":{"Latitude":52.305,"Longitude":4.74624},"BottomRight":{"Latitude":52.30291,"Longitude":4.75214}},"Address":{"Label":"1118 CP, Schiphol Centrum, Noord-Holland, Nederland","Country":"NLD","State":"Noord-Holland","County":"Haarlemmermeer","City":"Schiphol Centrum","PostalCode":"1118 CP","AdditionalData":[{"value":"Nederland","key":"CountryName"},{"value":"Noord-Holland","key":"StateName"},{"value":"Haarlemmermeer","key":"CountyName"}]}}}]}]}}')
            ]),
        ]))->find('1118CP');

        $this->assertSame('https://geocoder.api.here.com/6.2/geocode.json?postalCode=1118CP&app_id=Q28yv1juyWQexhHdoJ1P&app_code=pJKdj-mUwxw1thw8EjCX9v&gen=9', $this->here->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Schiphol Centrum',
            'municipality' => 'Haarlemmermeer',
            'province' => 'Noord-Holland',
            'latitude' => 52.30307,
            'longitude' => 4.747
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code3()
    {
        $address = $this->here->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"Response":{"MetaInfo":{"Timestamp":"2019-08-04T11:59:53.297+0000"},"View":[{"_type":"SearchResultsViewType","ViewId":0,"Result":[{"Relevance":1.0,"MatchLevel":"postalCode","MatchQuality":{"PostalCode":1.0},"Location":{"LocationId":"NT_HQ-tDBAn7JgwVyX4pYauBB","LocationType":"area","DisplayPosition":{"Latitude":51.50099,"Longitude":-0.14068},"NavigationPosition":[{"Latitude":51.50099,"Longitude":-0.14068}],"MapView":{"TopLeft":{"Latitude":51.51448,"Longitude":-0.16235},"BottomRight":{"Latitude":51.4875,"Longitude":-0.11901}},"Address":{"Label":"SW1A 1AA, London, England, United Kingdom","Country":"GBR","State":"England","County":"London","City":"London","PostalCode":"SW1A 1AA","AdditionalData":[{"value":"United Kingdom","key":"CountryName"},{"value":"England","key":"StateName"},{"value":"London","key":"CountyName"}]}}}]}]}}')
            ]),
        ]))->find('SW1A1AA');

        $this->assertSame('https://geocoder.api.here.com/6.2/geocode.json?postalCode=SW1A1AA&app_id=Q28yv1juyWQexhHdoJ1P&app_code=pJKdj-mUwxw1thw8EjCX9v&gen=9', $this->here->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'London',
            'municipality' => 'London',
            'province' => 'England',
            'latitude' => 51.50099,
            'longitude' => -0.14068
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code4()
    {
        $address = $this->here->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"Response":{"MetaInfo":{"Timestamp":"2019-08-04T12:01:21.872+0000"},"View":[{"_type":"SearchResultsViewType","ViewId":0,"Result":[{"Relevance":1.0,"MatchLevel":"postalCode","MatchQuality":{"Country":1.0,"PostalCode":1.0},"Location":{"LocationId":"NT_-sYtJdLJ-kHPxUdkVsWWaC","LocationType":"area","DisplayPosition":{"Latitude":-37.79928,"Longitude":144.98755},"NavigationPosition":[{"Latitude":-37.79928,"Longitude":144.98755}],"MapView":{"TopLeft":{"Latitude":-37.79406,"Longitude":144.9826},"BottomRight":{"Latitude":-37.80963,"Longitude":144.99385}},"Address":{"Label":"3066, Collingwood, Melbourne, VIC, Australia","Country":"AUS","State":"VIC","City":"Melbourne","District":"Collingwood","PostalCode":"3066","AdditionalData":[{"value":"Australia","key":"CountryName"},{"value":"Victoria","key":"StateName"}]}}}]}]}}')
            ]),
        ]))->setOptions(['country' => 'AUS'])->find('3066');

        $this->assertSame('https://geocoder.api.here.com/6.2/geocode.json?postalCode=3066&app_id=Q28yv1juyWQexhHdoJ1P&app_code=pJKdj-mUwxw1thw8EjCX9v&gen=9&country=AUS', $this->here->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Melbourne',
            'municipality' => null,
            'province' => 'VIC',
            'latitude' => -37.79928,
            'longitude' => 144.98755
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code5()
    {
        $address = $this->here->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"Response":{"MetaInfo":{"Timestamp":"2019-08-04T12:01:57.682+0000"},"View":[{"_type":"SearchResultsViewType","ViewId":0,"Result":[{"Relevance":1.0,"MatchLevel":"postalCode","MatchQuality":{"Country":1.0,"PostalCode":1.0},"Location":{"LocationId":"NT_0feW1KN2fl7OdCCtmK8gZC","LocationType":"area","DisplayPosition":{"Latitude":48.85462,"Longitude":2.31306},"NavigationPosition":[{"Latitude":48.85462,"Longitude":2.31306}],"MapView":{"TopLeft":{"Latitude":48.86406,"Longitude":2.28985},"BottomRight":{"Latitude":48.84591,"Longitude":2.33328}},"Address":{"Label":"75007, Paris, Île-de-France, France","Country":"FRA","State":"Île-de-France","County":"Paris","City":"Paris","PostalCode":"75007","AdditionalData":[{"value":"France","key":"CountryName"},{"value":"Île-de-France","key":"StateName"},{"value":"Paris","key":"CountyName"}]}}}]}]}}')
            ]),
        ]))->setOptions(['country' => 'FRA'])->find('75007');

        $this->assertSame('https://geocoder.api.here.com/6.2/geocode.json?postalCode=75007&app_id=Q28yv1juyWQexhHdoJ1P&app_code=pJKdj-mUwxw1thw8EjCX9v&gen=9&country=FRA', $this->here->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Paris',
            'municipality' => 'Paris',
            'province' => 'Île-de-France',
            'latitude' => 48.85462,
            'longitude' => 2.31306
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code6()
    {
        $address = $this->here->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"Response":{"MetaInfo":{"Timestamp":"2019-08-04T12:02:33.977+0000"},"View":[{"_type":"SearchResultsViewType","ViewId":0,"Result":[{"Relevance":1.0,"MatchLevel":"postalCode","MatchQuality":{"Country":1.0,"PostalCode":1.0},"Location":{"LocationId":"NT_mD95NW7dPHanUKsrTh4PpD","LocationType":"area","DisplayPosition":{"Latitude":50.86295,"Longitude":4.35338},"NavigationPosition":[{"Latitude":50.86295,"Longitude":4.35338}],"MapView":{"TopLeft":{"Latitude":50.89337,"Longitude":4.33755},"BottomRight":{"Latitude":50.79628,"Longitude":4.40193}},"Address":{"Label":"1000, Brussel, België","Country":"BEL","State":"Brussel","County":"Brussel","City":"Brussel","PostalCode":"1000","AdditionalData":[{"value":"België","key":"CountryName"},{"value":"Brussel","key":"StateName"},{"value":"Brussel","key":"CountyName"}]}}}]}]}}')
            ]),
        ]))->setOptions(['country' => 'BEL'])->find('1000');

        $this->assertSame('https://geocoder.api.here.com/6.2/geocode.json?postalCode=1000&app_id=Q28yv1juyWQexhHdoJ1P&app_code=pJKdj-mUwxw1thw8EjCX9v&gen=9&country=BEL', $this->here->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Brussel',
            'municipality' => 'Brussel',
            'province' => 'Brussel',
            'latitude' => 50.86295,
            'longitude' => 4.35338
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code7()
    {
        $address = $this->here->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"Response":{"MetaInfo":{"Timestamp":"2019-08-04T12:03:07.553+0000"},"View":[{"_type":"SearchResultsViewType","ViewId":0,"Result":[{"Relevance":1.0,"MatchLevel":"postalCode","MatchQuality":{"Country":1.0,"PostalCode":1.0},"Location":{"LocationId":"NT_jKm69UMPlnMI8wzeyK1gHB","LocationType":"area","DisplayPosition":{"Latitude":52.53157,"Longitude":13.38344},"NavigationPosition":[{"Latitude":52.53157,"Longitude":13.38344}],"MapView":{"TopLeft":{"Latitude":52.53946,"Longitude":13.36569},"BottomRight":{"Latitude":52.52368,"Longitude":13.40161}},"Address":{"Label":"10115, Berlin, Deutschland","Country":"DEU","State":"Berlin","County":"Berlin","City":"Berlin","PostalCode":"10115","AdditionalData":[{"value":"Deutschland","key":"CountryName"},{"value":"Berlin","key":"StateName"},{"value":"Berlin","key":"CountyName"}]}}}]}]}}')
            ]),
        ]))->setOptions(['country' => 'DE'])->find('10115');

        $this->assertSame('https://geocoder.api.here.com/6.2/geocode.json?postalCode=10115&app_id=Q28yv1juyWQexhHdoJ1P&app_code=pJKdj-mUwxw1thw8EjCX9v&gen=9&country=DE', $this->here->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Berlin',
            'municipality' => 'Berlin',
            'province' => 'Berlin',
            'latitude' => 52.53157,
            'longitude' => 13.38344
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code8()
    {
        $address = $this->here->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"Response":{"MetaInfo":{"Timestamp":"2019-08-04T12:03:43.209+0000"},"View":[{"_type":"SearchResultsViewType","ViewId":0,"Result":[{"Relevance":1.0,"MatchLevel":"postalCode","MatchQuality":{"Country":1.0,"PostalCode":1.0},"Location":{"LocationId":"NT_nv-GMSPYgc3dcPIJZMZxqD","LocationType":"area","DisplayPosition":{"Latitude":48.20908,"Longitude":16.36986},"NavigationPosition":[{"Latitude":48.20908,"Longitude":16.36986}],"MapView":{"TopLeft":{"Latitude":48.21858,"Longitude":16.35513},"BottomRight":{"Latitude":48.19961,"Longitude":16.38493}},"Address":{"Label":"1010, Wien, Österreich","Country":"AUT","State":"Wien","County":"Wien","City":"Wien","PostalCode":"1010","AdditionalData":[{"value":"Österreich","key":"CountryName"},{"value":"Wien","key":"StateName"},{"value":"Wien","key":"CountyName"}]}}}]}]}}')
            ]),
        ]))->setOptions(['country' => 'AT'])->find('1010');

        $this->assertSame('https://geocoder.api.here.com/6.2/geocode.json?postalCode=1010&app_id=Q28yv1juyWQexhHdoJ1P&app_code=pJKdj-mUwxw1thw8EjCX9v&gen=9&country=AT', $this->here->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Wien',
            'municipality' => 'Wien',
            'province' => 'Wien',
            'latitude' => 48.20908,
            'longitude' => 16.36986
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_an_invalid_postal_code()
    {
        $address = $this->here->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"Response":{"MetaInfo":{"Timestamp":"2019-08-03T21:02:20.541+0000"},"View":[]}}')
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

        $this->here->findByPostcodeAndHouseNumber('1118CP', '202');
    }
}
