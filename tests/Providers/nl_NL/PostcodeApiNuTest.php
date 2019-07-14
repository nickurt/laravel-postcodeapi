<?php

namespace nickurt\PostcodeApi\tests\Providers\nl_NL;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\tests\TestCase;
use PostcodeApi;

class PostcodeApiNuTest extends TestCase
{
    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        $postcodeApi = PostcodeApi::create('PostcodeApiNu')->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"_embedded":{"addresses":[{"purpose":"kantoorfunctie","postcode":"1118CP","surface":16800,"municipality":{"id":"0394","label":"Haarlemmermeer"},"city":{"id":"1618","label":"Schiphol"},"letter":null,"geo":{"center":{"rd":{"type":"Point","coordinates":[111396.536,479739.602],"crs":{"type":"name","properties":{"name":"urn:ogc:def:crs:EPSG::28992"}}},"wgs84":{"type":"Point","coordinates":[4.7479077,52.3038972],"crs":{"type":"name","properties":{"name":"urn:ogc:def:crs:OGC:1.3:CRS84"}}}}},"nen5825":{"postcode":"1118 CP","street":"EVERT VAN DE BEEKSTRAAT"},"addition":null,"number":202,"year":2007,"province":{"id":"27","label":"Noord-Holland"},"id":"0394200001001951","type":"Verblijfsobject","street":"Evert van de Beekstraat","_links":{"self":{"href":"https://postcode-api.apiwise.nl/v2/addresses/0394200001001951/"}}},{"purpose":"overige gebruiksfunctie","postcode":"1118CP","surface":130,"municipality":{"id":"0394","label":"Haarlemmermeer"},"city":{"id":"1618","label":"Schiphol"},"letter":null,"geo":{"center":{"rd":{"type":"Point","coordinates":[111274.233,479651.927],"crs":{"type":"name","properties":{"name":"urn:ogc:def:crs:EPSG::28992"}}},"wgs84":{"type":"Point","coordinates":[4.746126,52.3030996],"crs":{"type":"name","properties":{"name":"urn:ogc:def:crs:OGC:1.3:CRS84"}}}}},"nen5825":{"postcode":"1118 CP","street":"EVERT VAN DE BEEKSTRAAT"},"addition":null,"number":300,"year":2000,"province":{"id":"27","label":"Noord-Holland"},"id":"0394200001001952","type":"Verblijfsobject","street":"Evert van de Beekstraat","_links":{"self":{"href":"https://postcode-api.apiwise.nl/v2/addresses/0394200001001952/"}}},{"purpose":"overige gebruiksfunctie","postcode":"1118CP","surface":130,"municipality":{"id":"0394","label":"Haarlemmermeer"},"city":{"id":"1618","label":"Schiphol"},"letter":null,"geo":{"center":{"rd":{"type":"Point","coordinates":[111277.672,479646.361],"crs":{"type":"name","properties":{"name":"urn:ogc:def:crs:EPSG::28992"}}},"wgs84":{"type":"Point","coordinates":[4.7461771,52.3030498],"crs":{"type":"name","properties":{"name":"urn:ogc:def:crs:OGC:1.3:CRS84"}}}}},"nen5825":{"postcode":"1118 CP","street":"EVERT VAN DE BEEKSTRAAT"},"addition":null,"number":302,"year":2000,"province":{"id":"27","label":"Noord-Holland"},"id":"0394200001001953","type":"Verblijfsobject","street":"Evert van de Beekstraat","_links":{"self":{"href":"https://postcode-api.apiwise.nl/v2/addresses/0394200001001953/"}}},{"purpose":"overige gebruiksfunctie","postcode":"1118CP","surface":130,"municipality":{"id":"0394","label":"Haarlemmermeer"},"city":{"id":"1618","label":"Schiphol"},"letter":null,"geo":{"center":{"rd":{"type":"Point","coordinates":[111281.11,479640.794],"crs":{"type":"name","properties":{"name":"urn:ogc:def:crs:EPSG::28992"}}},"wgs84":{"type":"Point","coordinates":[4.7462283,52.303],"crs":{"type":"name","properties":{"name":"urn:ogc:def:crs:OGC:1.3:CRS84"}}}}},"nen5825":{"postcode":"1118 CP","street":"EVERT VAN DE BEEKSTRAAT"},"addition":null,"number":304,"year":2000,"province":{"id":"27","label":"Noord-Holland"},"id":"0394200001001954","type":"Verblijfsobject","street":"Evert van de Beekstraat","_links":{"self":{"href":"https://postcode-api.apiwise.nl/v2/addresses/0394200001001954/"}}},{"purpose":"overige gebruiksfunctie","postcode":"1118CP","surface":184,"municipality":{"id":"0394","label":"Haarlemmermeer"},"city":{"id":"1618","label":"Schiphol"},"letter":null,"geo":{"center":{"rd":{"type":"Point","coordinates":[111284.548,479635.227],"crs":{"type":"name","properties":{"name":"urn:ogc:def:crs:EPSG::28992"}}},"wgs84":{"type":"Point","coordinates":[4.7462794,52.3029503],"crs":{"type":"name","properties":{"name":"urn:ogc:def:crs:OGC:1.3:CRS84"}}}}},"nen5825":{"postcode":"1118 CP","street":"EVERT VAN DE BEEKSTRAAT"},"addition":null,"number":306,"year":2000,"province":{"id":"27","label":"Noord-Holland"},"id":"0394200001001955","type":"Verblijfsobject","street":"Evert van de Beekstraat","_links":{"self":{"href":"https://postcode-api.apiwise.nl/v2/addresses/0394200001001955/"}}}]},"_links":{"self":{"href":"https://postcode-api.apiwise.nl/v2/addresses/?postcode=1118CP"}}}')
            ]),
        ]))->find('1118CP');

        $this->assertInstanceOf(Address::class, $postcodeApi);

        $this->assertSame([
            'street' => 'Evert van de Beekstraat',
            'house_no' => null,
            'town' => 'Schiphol',
            'municipality' => 'Haarlemmermeer',
            'province' => 'Noord-Holland',
            'latitude' => 52.3038972,
            'longitude' => 4.7479077
        ], $postcodeApi->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_an_invalid_postal_code()
    {
        $this->markTestSkipped('Todo');
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_a_valid_postal_code()
    {
        $postcodeApi = PostcodeApi::create('PostcodeApiNu')->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"_embedded":{"addresses":[{"purpose":"kantoorfunctie","postcode":"1118CP","surface":16800,"municipality":{"id":"0394","label":"Haarlemmermeer"},"city":{"id":"1618","label":"Schiphol"},"letter":null,"geo":{"center":{"rd":{"type":"Point","coordinates":[111396.536,479739.602],"crs":{"type":"name","properties":{"name":"urn:ogc:def:crs:EPSG::28992"}}},"wgs84":{"type":"Point","coordinates":[4.7479077,52.3038972],"crs":{"type":"name","properties":{"name":"urn:ogc:def:crs:OGC:1.3:CRS84"}}}}},"nen5825":{"postcode":"1118 CP","street":"EVERT VAN DE BEEKSTRAAT"},"addition":null,"number":202,"year":2007,"province":{"id":"27","label":"Noord-Holland"},"id":"0394200001001951","type":"Verblijfsobject","street":"Evert van de Beekstraat","_links":{"self":{"href":"https://postcode-api.apiwise.nl/v2/addresses/0394200001001951/"}}}]},"_links":{"self":{"href":"https://postcode-api.apiwise.nl/v2/addresses/?postcode=1118CP&number=202"}}}')
            ]),
        ]))->findByPostcodeAndHouseNumber('75007', '202');

        $this->assertInstanceOf(Address::class, $postcodeApi);

        $this->assertSame([
            'street' => 'Evert van de Beekstraat',
            'house_no' => '202',
            'town' => 'Schiphol',
            'municipality' => 'Haarlemmermeer',
            'province' => 'Noord-Holland',
            'latitude' => 52.3038972,
            'longitude' => 4.7479077
        ], $postcodeApi->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_an_invalid_postal_code()
    {
        $this->markTestSkipped('Todo');
    }
}