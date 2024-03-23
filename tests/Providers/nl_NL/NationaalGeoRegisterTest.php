<?php

namespace nickurt\PostcodeApi\tests\Providers\nl_NL;

use Illuminate\Support\Facades\Http;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\nl_NL\NationaalGeoRegister;
use nickurt\PostcodeApi\tests\TestCase;

class NationaalGeoRegisterTest extends TestCase
{
    /** @var NationaalGeoRegister */
    protected $nationaalGeoRegister;

    public function setUp(): void
    {
        $this->nationaalGeoRegister = (new NationaalGeoRegister)
            ->setRequestUrl('https://api.pdok.nl/bzk/locatieserver/search/v3_1/free');
    }

    public function test_it_can_get_the_default_config_values_for_this_provider()
    {
        $this->assertSame(null, $this->nationaalGeoRegister->getApiKey());
        $this->assertSame('https://api.pdok.nl/bzk/locatieserver/search/v3_1/free', $this->nationaalGeoRegister->getRequestUrl());
    }

    public function test_it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        Http::fake(['https://api.pdok.nl/bzk/locatieserver/search/v3_1/free?q=postcode:1118CP&rows=1' => Http::response('{"response":{"numFound":6,"start":0,"maxScore":15.742893,"docs":[{"bron":"BAG","woonplaatscode":"1618","type":"postcode","woonplaatsnaam":"Schiphol","openbareruimtetype":"Weg","gemeentecode":"0394","weergavenaam":"Evert van de Beekstraat, 1118CP Schiphol","straatnaam_verkort":"Evert van de Beekstr","id":"pcd-09770981e1b8842ea384e1ff1b3f32ee","gemeentenaam":"Haarlemmermeer","identificatie":"0394300000000046_1118CP","openbareruimte_id":"0394300000000046","provinciecode":"PV27","postcode":"1118CP","provincienaam":"Noord-Holland","centroide_ll":"POINT(4.74654356 52.3031994)","provincieafkorting":"NH","centroide_rd":"POINT(111302.82 479662.782)","straatnaam":"Evert van de Beekstraat","score":15.742893}]}}')]);

        $address = $this->nationaalGeoRegister->find('1118CP');

        $this->assertSame('https://api.pdok.nl/bzk/locatieserver/search/v3_1/free?q=postcode:1118CP&rows=1', $this->nationaalGeoRegister->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => 'Evert van de Beekstraat',
            'house_no' => null,
            'town' => 'Schiphol',
            'municipality' => 'Haarlemmermeer',
            'province' => 'Noord-Holland',
            'latitude' => 52.3031994,
            'longitude' => 4.74654356,
        ], $address->toArray());
    }

    public function test_it_can_get_the_correct_values_for_find_an_invalid_postal_code()
    {
        Http::fake(['https://api.pdok.nl/bzk/locatieserver/search/v3_1/free?q=postcode:XXXXAB&rows=1' => Http::response('{"response":{"numFound":0,"start":0,"maxScore":0,"docs":[]}}')]);

        $address = $this->nationaalGeoRegister->find('XXXXAB');

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
        Http::fake(['https://api.pdok.nl/bzk/locatieserver/search/v3_1/free?q=postcode:1118CP%20and%20housenumber:202&rows=1' => Http::response('{"response":{"numFound":1,"start":0,"maxScore":23.428492,"docs":[{"bron":"BAG","woonplaatscode":"1618","type":"adres","woonplaatsnaam":"Schiphol","wijkcode":"WK039416","huis_nlt":"202","openbareruimtetype":"Weg","buurtnaam":"Schiphol","gemeentecode":"0394","rdf_seealso":"http://bag.basisregistraties.overheid.nl/bag/id/nummeraanduiding/0394200001001951","weergavenaam":"Evert van de Beekstraat 202, 1118CP Schiphol","straatnaam_verkort":"Evert van de Beekstr","id":"adr-0a072b170a52946ef4f20cec3b2693e7","gekoppeld_perceel":["HLM03-AK-2322"],"gemeentenaam":"Haarlemmermeer","buurtcode":"BU03941663","wijknaam":"Schiphol","identificatie":"0394010001001991-0394200001001951","openbareruimte_id":"0394300000000046","waterschapsnaam":"HH van Rijnland","provinciecode":"PV27","postcode":"1118CP","provincienaam":"Noord-Holland","centroide_ll":"POINT(4.74790756 52.30389723)","nummeraanduiding_id":"0394200001001951","waterschapscode":"13","adresseerbaarobject_id":"0394010001001991","huisnummer":202,"provincieafkorting":"NH","centroide_rd":"POINT(111396.536 479739.602)","straatnaam":"Evert van de Beekstraat","score":23.428492}]}}')]);

        $address = $this->nationaalGeoRegister->findByPostcodeAndHouseNumber('1118CP', '202');

        $this->assertSame('https://api.pdok.nl/bzk/locatieserver/search/v3_1/free?q=postcode:1118CP%20and%20housenumber:202&rows=1', $this->nationaalGeoRegister->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => 'Evert van de Beekstraat',
            'house_no' => '202',
            'town' => 'Schiphol',
            'municipality' => 'Haarlemmermeer',
            'province' => 'Noord-Holland',
            'latitude' => 52.30389723,
            'longitude' => 4.74790756,
        ], $address->toArray());
    }

    public function test_it_can_get_the_correct_values_for_find_by_postcode_and_house_number_an_invalid_postal_code()
    {
        Http::fake(['https://api.pdok.nl/bzk/locatieserver/search/v3_1/free?q=postcode:XXXXAB%20and%20housenumber:1&rows=1' => Http::response('{"response":{"numFound":0,"start":0,"maxScore":0,"docs":[]}}')]);

        $address = $this->nationaalGeoRegister->findByPostcodeAndHouseNumber('XXXXAB', '1');

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
