<?php

namespace nickurt\PostcodeApi\tests\Providers\en_US;

use Illuminate\Support\Facades\Http;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Exception\NotSupportedException;
use nickurt\PostcodeApi\tests\TestCase;

class TomTomTest extends TestCase
{
    /** @var \nickurt\Providers\Providers\en_US\TomTom */
    protected $tomTom;

    public function setUp(): void
    {
        $this->tomTom = (new \nickurt\PostcodeApi\Providers\en_US\TomTom())
            ->setRequestUrl('https://api.tomtom.com/search/2/geocode/%s.json')
            ->setApiKey('fTBgJDvhz42xOaFykyPQsC2frczxZeC2');
    }

    public function test_it_can_get_the_default_config_values_for_this_provider()
    {
        $this->assertSame('fTBgJDvhz42xOaFykyPQsC2frczxZeC2', $this->tomTom->getApiKey());
        $this->assertSame('https://api.tomtom.com/search/2/geocode/%s.json', $this->tomTom->getRequestUrl());
    }

    public function test_it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        Http::fake(['https://api.tomtom.com/search/2/geocode/92270.json?key=fTBgJDvhz42xOaFykyPQsC2frczxZeC2&countrySet=US' => Http::response('{"summary":{"query":"92270","queryType":"NON_NEAR","queryTime":20,"numResults":9,"offset":0,"totalResults":994,"fuzzyLevel":1},"results":[{"type":"Geography","id":"US/GEO/p0/195217","score":2.756,"entityType":"PostalCodeArea","address":{"municipalitySubdivision":"Rancho Mirage","municipality":"Rancho Mirage","countrySecondarySubdivision":"Riverside","countryTertiarySubdivision":"Cathedral City-Palm Desert","countrySubdivision":"CA","postalCode":"92270","countryCode":"US","country":"United States","countryCodeISO3":"USA","freeformAddress":"Rancho Mirage, CA 92270","countrySubdivisionName":"California"},"position":{"lat":33.76666,"lon":-116.41769},"viewport":{"topLeftPoint":{"lat":33.83747,"lon":-116.46654},"btmRightPoint":{"lat":33.71407,"lon":-116.38801}},"boundingBox":{"topLeftPoint":{"lat":33.83747,"lon":-116.46654},"btmRightPoint":{"lat":33.71407,"lon":-116.38801}},"dataSources":{"geometry":{"id":"00005543-3200-3c00-0000-00004d8bb043"}}},{"type":"Street","id":"US/STR/p0/169","score":2.096,"address":{"streetName":"Desert Drive","municipalitySubdivision":"Rancho Mirage","municipality":"Rancho Mirage","countrySecondarySubdivision":"Riverside","countryTertiarySubdivision":"Cathedral City-Palm Desert","countrySubdivision":"CA","postalCode":"92270","extendedPostalCode":"9227049, 922704914, 922704918, 922704919, 922704920, 922704923, 922704924, 922704926, 922704951, 922704959","countryCode":"US","country":"United States","countryCodeISO3":"USA","freeformAddress":"Desert Drive, Rancho Mirage, CA 92270","countrySubdivisionName":"California"},"position":{"lat":33.73457,"lon":-116.40662},"viewport":{"topLeftPoint":{"lat":33.73497,"lon":-116.41147},"btmRightPoint":{"lat":33.73227,"lon":-116.4012}}},{"type":"Street","id":"US/STR/p0/532392","score":2.096,"address":{"streetName":"East Veldt Street","municipalitySubdivision":"Rancho Mirage","municipality":"Rancho Mirage","countrySecondarySubdivision":"Riverside","countryTertiarySubdivision":"Cathedral City-Palm Desert","countrySubdivision":"CA","postalCode":"92270","countryCode":"US","country":"United States","countryCodeISO3":"USA","freeformAddress":"East Veldt Street, Rancho Mirage, CA 92270","countrySubdivisionName":"California"},"position":{"lat":33.74098,"lon":-116.41118},"viewport":{"topLeftPoint":{"lat":33.74122,"lon":-116.41169},"btmRightPoint":{"lat":33.74066,"lon":-116.4108}}},{"type":"Street","id":"US/STR/p0/613764","score":2.096,"address":{"streetName":"Fincher Way","municipalitySubdivision":"Rancho Mirage","municipality":"Rancho Mirage","countrySecondarySubdivision":"Riverside","countryTertiarySubdivision":"Cathedral City-Palm Desert","countrySubdivision":"CA","postalCode":"92270","extendedPostalCode":"922703036","countryCode":"US","country":"United States","countryCodeISO3":"USA","freeformAddress":"Fincher Way, Rancho Mirage, CA 92270","countrySubdivisionName":"California"},"position":{"lat":33.76172,"lon":-116.42594},"viewport":{"topLeftPoint":{"lat":33.76573,"lon":-116.42742},"btmRightPoint":{"lat":33.75781,"lon":-116.42592}}},{"type":"Street","id":"US/STR/p0/694526","score":2.096,"address":{"streetName":"Emerald Court","municipalitySubdivision":"Rancho Mirage","municipality":"Rancho Mirage","countrySecondarySubdivision":"Riverside","countryTertiarySubdivision":"Cathedral City-Palm Desert","countrySubdivision":"CA","postalCode":"92270","extendedPostalCode":"922708011","countryCode":"US","country":"United States","countryCodeISO3":"USA","freeformAddress":"Emerald Court, Rancho Mirage, CA 92270","countrySubdivisionName":"California"},"position":{"lat":33.7488,"lon":-116.39279},"viewport":{"topLeftPoint":{"lat":33.7488,"lon":-116.3946},"btmRightPoint":{"lat":33.74879,"lon":-116.39279}}},{"type":"Street","id":"US/STR/p0/809541","score":2.096,"address":{"streetName":"San Gorgonio Road","municipalitySubdivision":"Rancho Mirage","municipality":"Rancho Mirage","countrySecondarySubdivision":"Riverside","countryTertiarySubdivision":"Cathedral City-Palm Desert","countrySubdivision":"CA","postalCode":"92270","extendedPostalCode":"922704106, 922704112, 922704115, 922704124, 922704139, 922704141, 922704142, 922704235, 922704236, 922704260","countryCode":"US","country":"United States","countryCodeISO3":"USA","freeformAddress":"San Gorgonio Road, Rancho Mirage, CA 92270","countrySubdivisionName":"California"},"position":{"lat":33.74291,"lon":-116.41796},"viewport":{"topLeftPoint":{"lat":33.7443,"lon":-116.42089},"btmRightPoint":{"lat":33.74064,"lon":-116.41574}}},{"type":"Street","id":"US/STR/p0/1106387","score":2.096,"address":{"streetName":"Rancho Las Palmas Drive","municipalitySubdivision":"Rancho Mirage","municipality":"Rancho Mirage","countrySecondarySubdivision":"Riverside","countryTertiarySubdivision":"Cathedral City-Palm Desert","countrySubdivision":"CA","postalCode":"92270","extendedPostalCode":"922703700, 922703726, 922703727, 922703728, 922703729, 922703730, 922703731, 922703738, 922703739, 922703740, 922703741, 922703742, 922703743, 922703744, 922703745, 922703746, 922703747, 9227041, 922704134, 922704135, 922704137, 922704144, 922704145, 922704147, 922704151, 922704152, 922704153, 922704154, 922704155, 922704156, 922704157, 922704158, 922704159, 922704160, 922704161, 922704162, 922704163, 922704164, 922704165, 922704166, 922704167, 922704168, 922704169, 922704170, 922704171, 922704172, 922704173, 922704174, 922704175, 922704176, 922704177, 922704178, 922704179, 922704180, 922704181, 922704182, 922704183, 922704184, 922704185, 922704186, 922704187, 922704188, 922704189, 922704190, 922704191, 922704192, 922704193, 922704194, 922704195, 922704198, 922704199, 922704207, 922704262, 922704266, 922704267, 922704268, 922704269, 922704270, 922704271, 922704272, 922704273, 922704274, 922704275, 922704276, 922704277, 922704278, 922704279, 922704280, 922704281, 922704282, 922704283, 922704284, 922704285, 922704286, 922704287, 922704288, 922704289, 922704290, 922704291, 922704292, 922704293, 922704294, 922704295, 922704296, 922704297, 922704298, 922704299, 922704302, 922704303, 922704304, 922704309, 922704314, 922704315, 922704317, 922704321, 922704328, 922704332, 922704333, 922704335, 922704338, 922704341, 922704342, 922704349, 922704350, 922704351, 922704364, 922704367, 922704368, 922704369, 922704370, 922704371, 922704372, 922704375, 922704376, 922704377, 922704378, 922704379, 922704380, 922704381, 922704382, 922704383, 922704384, 922704385, 922704386, 922704387, 922704388, 922704389, 922704390, 922704391, 922704392, 922704393, 922704394, 922704395, 922704396, 922704397, 922704398, 922704399, 922704531, 922705509, 922705511, 922705512, 922705513, 922705514, 922705515, 9227099, 922709991, 922709998, 922709999","countryCode":"US","country":"United States","countryCodeISO3":"USA","freeformAddress":"Rancho Las Palmas Drive, Rancho Mirage, CA 92270","countrySubdivisionName":"California"},"position":{"lat":33.74149,"lon":-116.41212},"viewport":{"topLeftPoint":{"lat":33.74287,"lon":-116.41572},"btmRightPoint":{"lat":33.73928,"lon":-116.40763}}},{"type":"Street","id":"US/STR/p0/1106713","score":2.096,"address":{"streetName":"Avenida Las Palmas","municipalitySubdivision":"Rancho Mirage","municipality":"Rancho Mirage","countrySecondarySubdivision":"Riverside","countryTertiarySubdivision":"Cathedral City-Palm Desert","countrySubdivision":"CA","postalCode":"92270","extendedPostalCode":"9227046, 922704602, 922704670, 922704671, 922704675, 922704676, 922704677, 922704678","countryCode":"US","country":"United States","countryCodeISO3":"USA","freeformAddress":"Avenida Las Palmas, Rancho Mirage, CA 92270","countrySubdivisionName":"California"},"position":{"lat":33.7394,"lon":-116.39973},"viewport":{"topLeftPoint":{"lat":33.74836,"lon":-116.41053},"btmRightPoint":{"lat":33.73038,"lon":-116.38891}}},{"type":"Street","id":"US/STR/p0/1417683","score":2.096,"address":{"streetName":"Rattler Road","municipalitySubdivision":"Rancho Mirage","municipality":"Rancho Mirage","countrySecondarySubdivision":"Riverside","countryTertiarySubdivision":"Cathedral City-Palm Desert","countrySubdivision":"CA","postalCode":"92270","extendedPostalCode":"922702702, 922702766","countryCode":"US","country":"United States","countryCodeISO3":"USA","freeformAddress":"Rattler Road, Rancho Mirage, CA 92270","countrySubdivisionName":"California"},"position":{"lat":33.82333,"lon":-116.43212},"viewport":{"topLeftPoint":{"lat":33.83232,"lon":-116.44293},"btmRightPoint":{"lat":33.81434,"lon":-116.42128}}}]}')]);

        $address = $this->tomTom->setOptions(['countrySet' => 'US'])->find('92270');

        $this->assertSame('https://api.tomtom.com/search/2/geocode/92270.json?key=fTBgJDvhz42xOaFykyPQsC2frczxZeC2&countrySet=US', $this->tomTom->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Rancho Mirage',
            'municipality' => 'Rancho Mirage',
            'province' => 'CA',
            'latitude' => 33.76666,
            'longitude' => -116.41769,
        ], $address->toArray());
    }

    public function test_it_can_get_the_correct_values_for_find_a_valid_postal_code2()
    {
        Http::fake(['https://api.tomtom.com/search/2/geocode/1118CP.json?key=fTBgJDvhz42xOaFykyPQsC2frczxZeC2&countrySet=nl' => Http::response('{"summary":{"query":"1118cp","queryType":"NON_NEAR","queryTime":13,"numResults":1,"offset":0,"totalResults":1,"fuzzyLevel":1},"results":[{"type":"Street","id":"NL/STR/p0/280551","score":2.3056,"address":{"streetName":"Evert van de Beekstraat","municipalitySubdivision":"Schiphol","municipality":"Haarlemmermeer","countrySubdivision":"Noord-Holland","postalCode":"1118","extendedPostalCode":"1118CL, 1118CM, 1118CN, 1118CP, 1118CX, 1118CZ","countryCode":"NL","country":"Nederland","countryCodeISO3":"NLD","freeformAddress":"Evert van de Beekstraat, Haarlemmermeer (Schiphol)"},"position":{"lat":52.30427,"lon":4.75021},"viewport":{"topLeftPoint":{"lat":52.30563,"lon":4.74618},"btmRightPoint":{"lat":52.3028,"lon":4.75387}}}]}')]);

        $address = $this->tomTom->setOptions(['countrySet' => 'nl'])->find('1118CP');

        $this->assertSame('https://api.tomtom.com/search/2/geocode/1118CP.json?key=fTBgJDvhz42xOaFykyPQsC2frczxZeC2&countrySet=nl', $this->tomTom->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Schiphol',
            'municipality' => 'Haarlemmermeer',
            'province' => 'Noord-Holland',
            'latitude' => 52.30427,
            'longitude' => 4.75021,
        ], $address->toArray());
    }

    public function test_it_can_get_the_correct_values_for_find_a_valid_postal_code3()
    {
        Http::fake(['https://api.tomtom.com/search/2/geocode/SW1A1AA.json?key=fTBgJDvhz42xOaFykyPQsC2frczxZeC2' => Http::response('{"summary":{"query":"sw1a1aa","queryType":"NON_NEAR","queryTime":16,"numResults":1,"offset":0,"totalResults":1,"fuzzyLevel":1},"results":[{"type":"Street","id":"GB/STR/p0/451973","score":2.3056,"address":{"streetName":"","municipalitySubdivision":"Westminster","municipality":"London","countrySecondarySubdivision":"London","countrySubdivision":"ENG","postalCode":"SW1A","extendedPostalCode":"SW1A 1AA","countryCode":"GB","country":"United Kingdom","countryCodeISO3":"GBR","freeformAddress":"London (Westminster), SW1A 1AA","countrySubdivisionName":"England"},"position":{"lat":51.50127,"lon":-0.1402},"viewport":{"topLeftPoint":{"lat":51.50128,"lon":-0.14048},"btmRightPoint":{"lat":51.50121,"lon":-0.13991}}}]}')]);

        $address = $this->tomTom->find('SW1A1AA');

        $this->assertSame('https://api.tomtom.com/search/2/geocode/SW1A1AA.json?key=fTBgJDvhz42xOaFykyPQsC2frczxZeC2', $this->tomTom->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Westminster',
            'municipality' => 'London',
            'province' => 'ENG',
            'latitude' => 51.50127,
            'longitude' => -0.1402,
        ], $address->toArray());
    }

    public function test_it_can_get_the_correct_values_for_find_a_valid_postal_code4()
    {
        Http::fake(['https://api.tomtom.com/search/2/geocode/3066.json?key=fTBgJDvhz42xOaFykyPQsC2frczxZeC2&countrySet=au' => Http::response('{"summary":{"query":"3066","queryType":"NON_NEAR","queryTime":14,"numResults":8,"offset":0,"totalResults":208,"fuzzyLevel":1},"results":[{"type":"Geography","id":"AU/GEO/p0/15692","score":2.756,"entityType":"PostalCodeArea","address":{"municipalitySubdivision":"Collingwood","municipality":"Melbourne","countrySecondarySubdivision":"Melbourne","countrySubdivision":"Victoria","postalCode":"3066","countryCode":"AU","country":"Australia","countryCodeISO3":"AUS","freeformAddress":"Melbourne Collingwood, Victoria, 3066"},"position":{"lat":-37.80312,"lon":144.98365},"viewport":{"topLeftPoint":{"lat":-37.79388,"lon":144.98256},"btmRightPoint":{"lat":-37.80979,"lon":144.99377}},"boundingBox":{"topLeftPoint":{"lat":-37.79388,"lon":144.98256},"btmRightPoint":{"lat":-37.80979,"lon":144.99377}},"dataSources":{"geometry":{"id":"00004d47-4d00-3c00-0000-00004dc8b870"}}},{"type":"Street","id":"AU/STR/p0/173208","score":2.096,"address":{"streetName":"Easey Street","municipalitySubdivision":"Collingwood","municipality":"Melbourne","countrySecondarySubdivision":"Melbourne","countrySubdivision":"Victoria","postalCode":"3066","countryCode":"AU","country":"Australia","countryCodeISO3":"AUS","freeformAddress":"Easey Street, Melbourne Collingwood, Victoria, 3066"},"position":{"lat":-37.79801,"lon":144.98886},"viewport":{"topLeftPoint":{"lat":-37.79756,"lon":144.98445},"btmRightPoint":{"lat":-37.79842,"lon":144.99298}}},{"type":"Street","id":"AU/STR/p0/182572","score":2.096,"address":{"streetName":"Budd Street","municipalitySubdivision":"Collingwood","municipality":"Melbourne","countrySecondarySubdivision":"Melbourne","countrySubdivision":"Victoria","postalCode":"3066","countryCode":"AU","country":"Australia","countryCodeISO3":"AUS","freeformAddress":"Budd Street, Melbourne Collingwood, Victoria, 3066"},"position":{"lat":-37.79677,"lon":144.98698},"viewport":{"topLeftPoint":{"lat":-37.79428,"lon":144.98657},"btmRightPoint":{"lat":-37.79921,"lon":144.9874}}},{"type":"Street","id":"AU/STR/p0/185156","score":2.096,"address":{"streetName":"Harmsworth Street","municipalitySubdivision":"Collingwood","municipality":"Melbourne","countrySecondarySubdivision":"Melbourne","countrySubdivision":"Victoria","postalCode":"3066","countryCode":"AU","country":"Australia","countryCodeISO3":"AUS","freeformAddress":"Harmsworth Street, Melbourne Collingwood, Victoria, 3066"},"position":{"lat":-37.80099,"lon":144.99079},"viewport":{"topLeftPoint":{"lat":-37.79965,"lon":144.99052},"btmRightPoint":{"lat":-37.80231,"lon":144.99104}}},{"type":"Street","id":"AU/STR/p0/190619","score":2.096,"address":{"streetName":"Peters Lane","municipalitySubdivision":"Collingwood","municipality":"Melbourne","countrySecondarySubdivision":"Melbourne","countrySubdivision":"Victoria","postalCode":"3066","countryCode":"AU","country":"Australia","countryCodeISO3":"AUS","freeformAddress":"Peters Lane, Melbourne Collingwood, Victoria, 3066"},"position":{"lat":-37.8015,"lon":144.99263},"viewport":{"topLeftPoint":{"lat":-37.8015,"lon":144.99263},"btmRightPoint":{"lat":-37.80152,"lon":144.99272}}},{"type":"Street","id":"AU/STR/p0/192369","score":2.096,"address":{"streetName":"Robert Street","municipalitySubdivision":"Collingwood","municipality":"Melbourne","countrySecondarySubdivision":"Melbourne","countrySubdivision":"Victoria","postalCode":"3066","countryCode":"AU","country":"Australia","countryCodeISO3":"AUS","freeformAddress":"Robert Street, Melbourne Collingwood, Victoria, 3066"},"position":{"lat":-37.80571,"lon":144.98724},"viewport":{"topLeftPoint":{"lat":-37.80559,"lon":144.98622},"btmRightPoint":{"lat":-37.80582,"lon":144.98825}}},{"type":"Street","id":"AU/STR/p0/192524","score":2.096,"address":{"streetName":"Blanche Street","municipalitySubdivision":"Collingwood","municipality":"Melbourne","countrySecondarySubdivision":"Melbourne","countrySubdivision":"Victoria","postalCode":"3066","countryCode":"AU","country":"Australia","countryCodeISO3":"AUS","freeformAddress":"Blanche Street, Melbourne Collingwood, Victoria, 3066"},"position":{"lat":-37.79523,"lon":144.98654},"viewport":{"topLeftPoint":{"lat":-37.79421,"lon":144.98635},"btmRightPoint":{"lat":-37.79636,"lon":144.98671}}},{"type":"Street","id":"AU/STR/p0/193465","score":2.096,"address":{"streetName":"Emma Street","municipalitySubdivision":"Collingwood","municipality":"Melbourne","countrySecondarySubdivision":"Melbourne","countrySubdivision":"Victoria","postalCode":"3066","countryCode":"AU","country":"Australia","countryCodeISO3":"AUS","freeformAddress":"Emma Street, Melbourne Collingwood, Victoria, 3066"},"position":{"lat":-37.79535,"lon":144.98582},"viewport":{"topLeftPoint":{"lat":-37.79413,"lon":144.98558},"btmRightPoint":{"lat":-37.79657,"lon":144.98601}}}]}')]);

        $address = $this->tomTom->setOptions(['countrySet' => 'au'])->find('3066');

        $this->assertSame('https://api.tomtom.com/search/2/geocode/3066.json?key=fTBgJDvhz42xOaFykyPQsC2frczxZeC2&countrySet=au', $this->tomTom->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Collingwood',
            'municipality' => 'Melbourne',
            'province' => 'Victoria',
            'latitude' => -37.80312,
            'longitude' => 144.98365,
        ], $address->toArray());
    }

    public function test_it_can_get_the_correct_values_for_find_a_valid_postal_code5()
    {
        Http::fake(['https://api.tomtom.com/search/2/geocode/75007.json?key=fTBgJDvhz42xOaFykyPQsC2frczxZeC2&countrySet=fr' => Http::response('{"summary":{"query":"75007","queryType":"NON_NEAR","queryTime":29,"numResults":10,"offset":0,"totalResults":264,"fuzzyLevel":1},"results":[{"type":"Geography","id":"FR/GEO/p0/106448","score":2.756,"entityType":"PostalCodeArea","address":{"municipalitySubdivision":"7ème Arrondissement","municipality":"Paris","countrySecondarySubdivision":"Paris","countrySubdivision":"Île-de-France","postalCode":"75007","countryCode":"FR","country":"France","countryCodeISO3":"FRA","freeformAddress":"Paris (7ème Arrondissement), 75007"},"position":{"lat":48.85798,"lon":2.31511},"viewport":{"topLeftPoint":{"lat":48.86376,"lon":2.28987},"btmRightPoint":{"lat":48.84593,"lon":2.33327}},"boundingBox":{"topLeftPoint":{"lat":48.86376,"lon":2.28987},"btmRightPoint":{"lat":48.84593,"lon":2.33327}},"dataSources":{"geometry":{"id":"00004632-3000-3c00-0000-00005163e0ac"}}},{"type":"Street","id":"FR/STR/p0/1062554","score":2.096,"address":{"streetName":"Port des Invalides","municipalitySubdivision":"7ème Arrondissement","municipality":"Paris","countrySecondarySubdivision":"Paris","countrySubdivision":"Île-de-France","postalCode":"75007","countryCode":"FR","country":"France","countryCodeISO3":"FRA","freeformAddress":"Port des Invalides, Paris (7ème Arrondissement), 75007"},"position":{"lat":48.86312,"lon":2.31376},"viewport":{"topLeftPoint":{"lat":48.86317,"lon":2.31175},"btmRightPoint":{"lat":48.86307,"lon":2.31573}}},{"type":"Street","id":"FR/STR/p0/1062870","score":2.096,"address":{"streetName":"Rue du Champ de Mars","municipalitySubdivision":"7ème Arrondissement","municipality":"Paris","countrySecondarySubdivision":"Paris","countrySubdivision":"Île-de-France","postalCode":"75007","countryCode":"FR","country":"France","countryCodeISO3":"FRA","freeformAddress":"Rue du Champ de Mars, Paris (7ème Arrondissement), 75007"},"position":{"lat":48.85625,"lon":2.30491},"viewport":{"topLeftPoint":{"lat":48.85675,"lon":2.30302},"btmRightPoint":{"lat":48.85582,"lon":2.30707}}},{"type":"Street","id":"FR/STR/p0/1063113","score":2.096,"address":{"streetName":"Avenue de Breteuil","municipalitySubdivision":"7ème Arrondissement","municipality":"Paris","countrySecondarySubdivision":"Paris","countrySubdivision":"Île-de-France","postalCode":"75007","countryCode":"FR","country":"France","countryCodeISO3":"FRA","freeformAddress":"Avenue de Breteuil, Paris (7ème Arrondissement), 75007"},"position":{"lat":48.85026,"lon":2.31237},"viewport":{"topLeftPoint":{"lat":48.85325,"lon":2.31132},"btmRightPoint":{"lat":48.84753,"lon":2.31271}}},{"type":"Street","id":"FR/STR/p0/1064152","score":2.096,"address":{"streetName":"Allée Thomy Thierry","municipalitySubdivision":"7ème Arrondissement","municipality":"Paris","countrySecondarySubdivision":"Paris","countrySubdivision":"Île-de-France","postalCode":"75007","countryCode":"FR","country":"France","countryCodeISO3":"FRA","freeformAddress":"Allée Thomy Thierry, Paris (7ème Arrondissement), 75007"},"position":{"lat":48.85477,"lon":2.29757},"viewport":{"topLeftPoint":{"lat":48.85704,"lon":2.29411},"btmRightPoint":{"lat":48.85232,"lon":2.30147}}},{"type":"Street","id":"FR/STR/p0/1065988","score":2.096,"address":{"streetName":"Allée Jean Paulhan","municipalitySubdivision":"7ème Arrondissement","municipality":"Paris","countrySecondarySubdivision":"Paris","countrySubdivision":"Île-de-France","postalCode":"75007","countryCode":"FR","country":"France","countryCodeISO3":"FRA","freeformAddress":"Allée Jean Paulhan, Paris (7ème Arrondissement), 75007"},"position":{"lat":48.85936,"lon":2.29552},"viewport":{"topLeftPoint":{"lat":48.85977,"lon":2.29453},"btmRightPoint":{"lat":48.85861,"lon":2.29641}}},{"type":"Street","id":"FR/STR/p0/1066570","score":2.096,"address":{"streetName":"Place Joffre","municipalitySubdivision":"7ème Arrondissement","municipality":"Paris","countrySecondarySubdivision":"Paris","countrySubdivision":"Île-de-France","postalCode":"75007","countryCode":"FR","country":"France","countryCodeISO3":"FRA","freeformAddress":"Place Joffre, Paris (7ème Arrondissement), 75007"},"position":{"lat":48.8529,"lon":2.30337},"viewport":{"topLeftPoint":{"lat":48.85427,"lon":2.30091},"btmRightPoint":{"lat":48.85118,"lon":2.30541}}},{"type":"Street","id":"FR/STR/p0/1068396","score":2.096,"address":{"streetName":"Avenue de Suffren","municipalitySubdivision":"15ème Arrondissement","municipality":"Paris","countrySecondarySubdivision":"Paris","countrySubdivision":"Île-de-France","postalCode":"75007, 75015","countryCode":"FR","country":"France","countryCodeISO3":"FRA","freeformAddress":"Avenue de Suffren, Paris (15ème Arrondissement)"},"position":{"lat":48.85154,"lon":2.30029},"viewport":{"topLeftPoint":{"lat":48.86062,"lon":2.28659},"btmRightPoint":{"lat":48.84264,"lon":2.31393}}},{"type":"Street","id":"FR/STR/p0/1070762","score":2.096,"address":{"streetName":"Quai Branly","municipalitySubdivision":"7ème Arrondissement","municipality":"Paris","countrySecondarySubdivision":"Paris","countrySubdivision":"Île-de-France","postalCode":"75007","countryCode":"FR","country":"France","countryCodeISO3":"FRA","freeformAddress":"Quai Branly, Paris (7ème Arrondissement), 75007"},"position":{"lat":48.86054,"lon":2.29563},"viewport":{"topLeftPoint":{"lat":48.86242,"lon":2.29099},"btmRightPoint":{"lat":48.85744,"lon":2.30157}}},{"type":"Street","id":"FR/STR/p0/1071119","score":2.096,"address":{"streetName":"Avenue Duquesne","municipalitySubdivision":"7ème Arrondissement","municipality":"Paris","countrySecondarySubdivision":"Paris","countrySubdivision":"Île-de-France","postalCode":"75007","countryCode":"FR","country":"France","countryCodeISO3":"FRA","freeformAddress":"Avenue Duquesne, Paris (7ème Arrondissement), 75007"},"position":{"lat":48.85162,"lon":2.31022},"viewport":{"topLeftPoint":{"lat":48.85413,"lon":2.30634},"btmRightPoint":{"lat":48.84917,"lon":2.31402}}}]}')]);

        $address = $this->tomTom->setOptions(['countrySet' => 'fr'])->find('75007');

        $this->assertSame('https://api.tomtom.com/search/2/geocode/75007.json?key=fTBgJDvhz42xOaFykyPQsC2frczxZeC2&countrySet=fr', $this->tomTom->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => '7ème Arrondissement',
            'municipality' => 'Paris',
            'province' => 'Île-de-France',
            'latitude' => 48.85798,
            'longitude' => 2.31511,
        ], $address->toArray());
    }

    public function test_it_can_get_the_correct_values_for_find_a_valid_postal_code6()
    {
        Http::fake(['https://api.tomtom.com/search/2/geocode/1000.json?key=fTBgJDvhz42xOaFykyPQsC2frczxZeC2&countrySet=be' => Http::response('{"summary":{"query":"1000","queryType":"NON_NEAR","queryTime":28,"numResults":10,"offset":0,"totalResults":1023,"fuzzyLevel":1},"results":[{"type":"Geography","id":"BE/GEO/p0/8046","score":2.756,"entityType":"PostalCodeArea","address":{"municipalitySubdivision":"Brussel","municipality":"Brussel","countrySecondarySubdivision":"Brussel Hoofdstad","countrySubdivision":"Brussel Hoofdstedelijk Gewest","postalCode":"1000","countryCode":"BE","country":"België","countryCodeISO3":"BEL","freeformAddress":"1000 Brussel"},"position":{"lat":50.84554,"lon":4.35571},"viewport":{"topLeftPoint":{"lat":50.88923,"lon":4.33549},"btmRightPoint":{"lat":50.79633,"lon":4.40162}},"boundingBox":{"topLeftPoint":{"lat":50.88923,"lon":4.33549},"btmRightPoint":{"lat":50.79633,"lon":4.40162}},"dataSources":{"geometry":{"id":"00004245-3200-3c00-0000-00004d7c6d07"}}},{"type":"Street","id":"BE/STR/p0/220","score":2.096,"address":{"streetName":"Pachecolaan","municipalitySubdivision":"Brussel","municipality":"Brussel","countrySecondarySubdivision":"Brussel Hoofdstad","countrySubdivision":"Brussel Hoofdstedelijk Gewest","postalCode":"1000","countryCode":"BE","country":"België","countryCodeISO3":"BEL","freeformAddress":"Pachecolaan, 1000 Brussel"},"position":{"lat":50.85225,"lon":4.36252},"viewport":{"topLeftPoint":{"lat":50.8542,"lon":4.36111},"btmRightPoint":{"lat":50.85038,"lon":4.3636}}},{"type":"Street","id":"BE/STR/p0/1291","score":2.096,"address":{"streetName":"Amazonendreef","municipalitySubdivision":"Brussel","municipality":"Brussel","countrySecondarySubdivision":"Brussel Hoofdstad","countrySubdivision":"Brussel Hoofdstedelijk Gewest","postalCode":"1000","countryCode":"BE","country":"België","countryCodeISO3":"BEL","freeformAddress":"Amazonendreef, 1000 Brussel"},"position":{"lat":50.80917,"lon":4.37335},"viewport":{"topLeftPoint":{"lat":50.81878,"lon":4.35993},"btmRightPoint":{"lat":50.80079,"lon":4.38839}}},{"type":"Street","id":"BE/STR/p0/1700","score":2.096,"address":{"streetName":"Kruidtuinlaan","municipalitySubdivision":"Brussel","municipality":"Brussel","countrySecondarySubdivision":"Brussel Hoofdstad","countrySubdivision":"Brussel Hoofdstedelijk Gewest","postalCode":"1000, 1210","countryCode":"BE","country":"België","countryCodeISO3":"BEL","freeformAddress":"Kruidtuinlaan, Brussel"},"position":{"lat":50.8546,"lon":4.36027},"viewport":{"topLeftPoint":{"lat":50.85629,"lon":4.35473},"btmRightPoint":{"lat":50.85305,"lon":4.3657}}},{"type":"Street","id":"BE/STR/p0/3086","score":2.096,"address":{"streetName":"Woudlaan","municipalitySubdivision":"Brussel","municipality":"Brussel","countrySecondarySubdivision":"Brussel Hoofdstad","countrySubdivision":"Brussel Hoofdstedelijk Gewest","postalCode":"1000, 1050","countryCode":"BE","country":"België","countryCodeISO3":"BEL","freeformAddress":"Woudlaan, Brussel"},"position":{"lat":50.80037,"lon":4.3944},"viewport":{"topLeftPoint":{"lat":50.80233,"lon":4.39107},"btmRightPoint":{"lat":50.79719,"lon":4.3963}}},{"type":"Street","id":"BE/STR/p0/3618","score":2.096,"address":{"streetName":"Louizalaan","municipalitySubdivision":"Brussels","municipality":"Brussels","countrySecondarySubdivision":"Brussels","countrySubdivision":"Brussels-Capital Region","postalCode":"1000, 1050, 1060","countryCode":"BE","country":"Belgium","countryCodeISO3":"BEL","freeformAddress":"Louizalaan, Brussels"},"position":{"lat":50.82647,"lon":4.36436},"viewport":{"topLeftPoint":{"lat":50.83413,"lon":4.34918},"btmRightPoint":{"lat":50.81614,"lon":4.37765}}},{"type":"Street","id":"BE/STR/p0/3868","score":2.096,"address":{"streetName":"Koninginnelaan","municipalitySubdivision":"Brussel","municipality":"Brussel","countrySecondarySubdivision":"Brussel Hoofdstad","countrySubdivision":"Brussel Hoofdstedelijk Gewest","postalCode":"1000, 1020, 1030","countryCode":"BE","country":"België","countryCodeISO3":"BEL","freeformAddress":"Koninginnelaan, Brussel"},"position":{"lat":50.87124,"lon":4.36108},"viewport":{"topLeftPoint":{"lat":50.8801,"lon":4.34686},"btmRightPoint":{"lat":50.86212,"lon":4.37536}}},{"type":"Street","id":"BE/STR/p0/5389","score":2.096,"address":{"streetName":"Slachthuislaan","municipalitySubdivision":"Brussel","municipality":"Brussel","countrySecondarySubdivision":"Brussel Hoofdstad","countrySubdivision":"Brussel Hoofdstedelijk Gewest","postalCode":"1000, 1080","countryCode":"BE","country":"België","countryCodeISO3":"BEL","freeformAddress":"Slachthuislaan, Brussel"},"position":{"lat":50.84754,"lon":4.33819},"viewport":{"topLeftPoint":{"lat":50.85018,"lon":4.33743},"btmRightPoint":{"lat":50.84492,"lon":4.33915}}},{"type":"Street","id":"BE/STR/p0/5723","score":2.096,"address":{"streetName":"Maalbeekdalhof","municipalitySubdivision":"Brussel","municipality":"Brussel","countrySecondarySubdivision":"Brussel Hoofdstad","countrySubdivision":"Brussel Hoofdstedelijk Gewest","postalCode":"1000, 1040","countryCode":"BE","country":"België","countryCodeISO3":"BEL","freeformAddress":"Maalbeekdalhof, Brussel"},"position":{"lat":50.84416,"lon":4.37807},"viewport":{"topLeftPoint":{"lat":50.84463,"lon":4.37779},"btmRightPoint":{"lat":50.84355,"lon":4.37833}}},{"type":"Street","id":"BE/STR/p0/6138","score":2.096,"address":{"streetName":"Legrandlaan","municipalitySubdivision":"Brussel","municipality":"Brussel","countrySecondarySubdivision":"Brussel Hoofdstad","countrySubdivision":"Brussel Hoofdstedelijk Gewest","postalCode":"1000, 1050, 1180","countryCode":"BE","country":"België","countryCodeISO3":"BEL","freeformAddress":"Legrandlaan, Brussel"},"position":{"lat":50.81527,"lon":4.36977},"viewport":{"topLeftPoint":{"lat":50.81561,"lon":4.36734},"btmRightPoint":{"lat":50.8149,"lon":4.3719}}}]}')]);

        $address = $this->tomTom->setOptions(['countrySet' => 'be'])->find('1000');

        $this->assertSame('https://api.tomtom.com/search/2/geocode/1000.json?key=fTBgJDvhz42xOaFykyPQsC2frczxZeC2&countrySet=be', $this->tomTom->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Brussel',
            'municipality' => 'Brussel',
            'province' => 'Brussel Hoofdstedelijk Gewest',
            'latitude' => 50.84554,
            'longitude' => 4.35571,
        ], $address->toArray());
    }

    public function test_it_can_get_the_correct_values_for_find_a_valid_postal_code7()
    {
        Http::fake(['https://api.tomtom.com/search/2/geocode/10115.json?key=fTBgJDvhz42xOaFykyPQsC2frczxZeC2&countrySet=de' => Http::response('{"summary":{"query":"10115","queryType":"NON_NEAR","queryTime":27,"numResults":2,"offset":0,"totalResults":71,"fuzzyLevel":1},"results":[{"type":"Geography","id":"DE/GEO/p0/66676","score":2.756,"entityType":"PostalCodeArea","address":{"municipalitySubdivision":"Mitte, Gesundbrunnen, Wedding, Moabit","municipality":"Berlin","countrySecondarySubdivision":"Berlin","countrySubdivision":"Berlin","postalCode":"10115","countryCode":"DE","country":"Deutschland","countryCodeISO3":"DEU","freeformAddress":"10115 Berlin (Mitte)"},"position":{"lat":52.53308,"lon":13.37786},"viewport":{"topLeftPoint":{"lat":52.54006,"lon":13.36572},"btmRightPoint":{"lat":52.52609,"lon":13.40135}},"boundingBox":{"topLeftPoint":{"lat":52.54006,"lon":13.36572},"btmRightPoint":{"lat":52.52609,"lon":13.40135}},"dataSources":{"geometry":{"id":"00004435-3800-3c00-0000-00004e614ef2"}}},{"type":"Street","id":"DE/STR/p0/1774860","score":2.096,"address":{"streetName":"","municipalitySubdivision":"Mitte","municipality":"Berlin","countrySecondarySubdivision":"Berlin","countrySubdivision":"Berlin","postalCode":"10115, 10117","countryCode":"DE","country":"Deutschland","countryCodeISO3":"DEU","freeformAddress":"Berlin (Mitte)"},"position":{"lat":52.52675,"lon":13.39679},"viewport":{"topLeftPoint":{"lat":52.52701,"lon":13.39668},"btmRightPoint":{"lat":52.52647,"lon":13.39685}}}]}')]);

        $address = $this->tomTom->setOptions(['countrySet' => 'de'])->find('10115');

        $this->assertSame('https://api.tomtom.com/search/2/geocode/10115.json?key=fTBgJDvhz42xOaFykyPQsC2frczxZeC2&countrySet=de', $this->tomTom->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Mitte, Gesundbrunnen, Wedding, Moabit',
            'municipality' => 'Berlin',
            'province' => 'Berlin',
            'latitude' => 52.53308,
            'longitude' => 13.37786,
        ], $address->toArray());
    }

    public function test_it_can_get_the_correct_values_for_find_a_valid_postal_code8()
    {
        Http::fake(['https://api.tomtom.com/search/2/geocode/1010.json?key=fTBgJDvhz42xOaFykyPQsC2frczxZeC2&countrySet=at' => Http::response('{"summary":{"query":"1010","queryType":"NON_NEAR","queryTime":26,"numResults":1,"offset":0,"totalResults":333,"fuzzyLevel":1},"results":[{"type":"Geography","id":"AT/GEO/p0/16582","score":2.756,"entityType":"PostalCodeArea","address":{"municipalitySubdivision":"1. Bezirk Innere Stadt","municipality":"Wien","countrySecondarySubdivision":"Wien","countrySubdivision":"Wien","postalCode":"1010","countryCode":"AT","country":"Österreich","countryCodeISO3":"AUT","freeformAddress":"1010 Wien (1. Bezirk Innere Stadt)"},"position":{"lat":48.20921,"lon":16.37278},"viewport":{"topLeftPoint":{"lat":48.21853,"lon":16.35507},"btmRightPoint":{"lat":48.19944,"lon":16.38497}},"boundingBox":{"topLeftPoint":{"lat":48.21853,"lon":16.35507},"btmRightPoint":{"lat":48.19944,"lon":16.38497}},"dataSources":{"geometry":{"id":"00004154-3200-3c00-0000-00004de73ce3"}}}]}')]);

        $address = $this->tomTom->setOptions(['countrySet' => 'at'])->find('1010');

        $this->assertSame('https://api.tomtom.com/search/2/geocode/1010.json?key=fTBgJDvhz42xOaFykyPQsC2frczxZeC2&countrySet=at', $this->tomTom->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => '1. Bezirk Innere Stadt',
            'municipality' => 'Wien',
            'province' => 'Wien',
            'latitude' => 48.20921,
            'longitude' => 16.37278,
        ], $address->toArray());
    }

    public function test_it_can_get_the_correct_values_for_find_an_invalid_postal_code()
    {
        Http::fake(['https://api.tomtom.com/search/2/geocode/zeroresults.json?key=fTBgJDvhz42xOaFykyPQsC2frczxZeC2' => Http::response('{"summary":{"query":"zeroresults","queryType":"NON_NEAR","queryTime":36,"numResults":0,"offset":0,"totalResults":0,"fuzzyLevel":2},"results":[]}')]);

        $address = $this->tomTom->find('zeroresults');

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
        $this->expectException(NotSupportedException::class);

        $this->tomTom->findByPostcodeAndHouseNumber('1118CP', '202');
    }
}
