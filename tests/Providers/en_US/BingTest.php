<?php

namespace nickurt\PostcodeApi\tests\Providers\en_US;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Exception\NotSupportedException;
use nickurt\PostcodeApi\Providers\en_US\Bing;
use nickurt\PostcodeApi\tests\Providers\BaseProviderTest;

class BingTest extends BaseProviderTest
{
    /** @var Bing */
    protected $bing;

    public function setUp(): void
    {
        $this->bing = (new Bing)
            ->setApiKey('KiDvfeMKAupV8LryymvklMJDEPJ4_04iLA2AN5Ayf4dUuwndTGlYPP3fOPFHXp0N');
    }

    /** @test */
    public function it_can_get_the_default_config_values_for_this_provider()
    {
        $this->assertSame('KiDvfeMKAupV8LryymvklMJDEPJ4_04iLA2AN5Ayf4dUuwndTGlYPP3fOPFHXp0N', $this->bing->getApiKey());
        $this->assertSame('https://dev.virtualearth.net/REST/v1/Locations', (string)$this->bing->getRequestUrl());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        $address = $this->bing->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"authenticationResultCode":"ValidCredentials","brandLogoUri":"http:\/\/dev.virtualearth.net\/Branding\/logo_powered_by.png","copyright":"Copyright © 2019 Microsoft and its suppliers. All rights reserved. This API cannot be accessed and the content and any results may not be used, reproduced or transmitted in any manner without express written permission from Microsoft Corporation.","resourceSets":[{"estimatedTotal":4,"resources":[{"__type":"Location:http:\/\/schemas.microsoft.com\/search\/local\/ws\/rest\/v1","bbox":[33.714130401611328,-116.47786712646484,33.836498260498047,-116.38819885253906],"name":"92270, CA","point":{"type":"Point","coordinates":[33.738651275634766,-116.41277313232422]},"address":{"adminDistrict":"CA","adminDistrict2":"Riverside County","countryRegion":"United States","formattedAddress":"92270, CA","locality":"Rancho Mirage","postalCode":"92270"},"confidence":"High","entityType":"Postcode1","geocodePoints":[{"type":"Point","coordinates":[33.738651275634766,-116.41277313232422],"calculationMethod":"Rooftop","usageTypes":["Display"]}],"matchCodes":["Ambiguous"]},{"__type":"Location:http:\/\/schemas.microsoft.com\/search\/local\/ws\/rest\/v1","bbox":[21.224599838256836,-98.013763427734375,21.244850158691406,-97.999229431152344],"name":"92270, Mexico","point":{"type":"Point","coordinates":[21.23505973815918,-98.0064926147461]},"address":{"adminDistrict":"Ver","adminDistrict2":"Ixcatepec","countryRegion":"Mexico","formattedAddress":"92270, Mexico","locality":"Primera Secc","postalCode":"92270"},"confidence":"Low","entityType":"Postcode1","geocodePoints":[{"type":"Point","coordinates":[21.23505973815918,-98.0064926147461],"calculationMethod":"Rooftop","usageTypes":["Display"]}],"matchCodes":["Ambiguous"]},{"__type":"Location:http:\/\/schemas.microsoft.com\/search\/local\/ws\/rest\/v1","bbox":[48.9033203125,2.2570199966430664,48.9268798828125,2.2806200981140137],"name":"92270, Hauts-de-Seine, France","point":{"type":"Point","coordinates":[48.91510009765625,2.2684590816497803]},"address":{"adminDistrict":"IdF","adminDistrict2":"Hauts-de-Seine","countryRegion":"France","formattedAddress":"92270, Hauts-de-Seine, France","locality":"Bois-Colombes","postalCode":"92270"},"confidence":"Low","entityType":"Postcode1","geocodePoints":[{"type":"Point","coordinates":[48.91510009765625,2.2684590816497803],"calculationMethod":"Rooftop","usageTypes":["Display"]}],"matchCodes":["Ambiguous"]},{"__type":"Location:http:\/\/schemas.microsoft.com\/search\/local\/ws\/rest\/v1","bbox":[58.9085807800293,22.256809234619141,58.938640594482422,22.321439743041992],"name":"92270, Estonia","point":{"type":"Point","coordinates":[58.923610687255859,22.28398323059082]},"address":{"adminDistrict":"Hiiumaa","adminDistrict2":"Hiiumaa vald","countryRegion":"Estonia","formattedAddress":"92270, Estonia","locality":"Heistesoo küla","postalCode":"92270"},"confidence":"Low","entityType":"Postcode1","geocodePoints":[{"type":"Point","coordinates":[58.923610687255859,22.28398323059082],"calculationMethod":"Rooftop","usageTypes":["Display"]}],"matchCodes":["Ambiguous"]}]}],"statusCode":200,"statusDescription":"OK","traceId":"ab7cff27a83a4df797c3596cbf2d9a1a|DU00000D7C|7.7.0.0|Ref A: 65592D4CFC304379BC9CB69ACDAA1304 Ref B: DB3EDGE1513 Ref C: 2019-08-04T12:14:08Z"}')
            ]),
        ]))->find('92270');

        $this->assertSame('https://dev.virtualearth.net/REST/v1/Locations?postalCode=92270&key=KiDvfeMKAupV8LryymvklMJDEPJ4_04iLA2AN5Ayf4dUuwndTGlYPP3fOPFHXp0N', (string)$this->bing->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Rancho Mirage',
            'municipality' => 'Riverside County',
            'province' => 'CA',
            'latitude' => 33.738651275634766,
            'longitude' => -116.41277313232422
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code2()
    {
        $address = $this->bing->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"authenticationResultCode":"ValidCredentials","brandLogoUri":"http:\/\/dev.virtualearth.net\/Branding\/logo_powered_by.png","copyright":"Copyright © 2019 Microsoft and its suppliers. All rights reserved. This API cannot be accessed and the content and any results may not be used, reproduced or transmitted in any manner without express written permission from Microsoft Corporation.","resourceSets":[{"estimatedTotal":1,"resources":[{"__type":"Location:http:\/\/schemas.microsoft.com\/search\/local\/ws\/rest\/v1","bbox":[52.283840179443359,4.7311282157897949,52.328765869140625,4.8097047805786133],"name":"1118, Netherlands","point":{"type":"Point","coordinates":[52.306304931640625,4.7690391540527344]},"address":{"adminDistrict":"North Holland","adminDistrict2":"Gemeente Haarlemmermeer","countryRegion":"Netherlands","formattedAddress":"1118, Netherlands","locality":"Schiphol Centrum","postalCode":"1118"},"confidence":"High","entityType":"Postcode1","geocodePoints":[{"type":"Point","coordinates":[52.306304931640625,4.7690391540527344],"calculationMethod":"Rooftop","usageTypes":["Display"]}],"matchCodes":["Good"]}]}],"statusCode":200,"statusDescription":"OK","traceId":"9cfaf48e6b244ea592891dd4f95751db|DU00000D70|7.7.0.0|Ref A: 6C92C0E8C8AF414AB6838B2577596190 Ref B: DB3EDGE1517 Ref C: 2019-08-04T10:20:06Z"}')
            ]),
        ]))->setOptions(['countryRegion' => 'nl'])->find('1118CP');

        $this->assertSame('https://dev.virtualearth.net/REST/v1/Locations?postalCode=1118CP&key=KiDvfeMKAupV8LryymvklMJDEPJ4_04iLA2AN5Ayf4dUuwndTGlYPP3fOPFHXp0N&countryRegion=nl', (string)$this->bing->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Schiphol Centrum',
            'municipality' => 'Gemeente Haarlemmermeer',
            'province' => 'North Holland',
            'latitude' => 52.306304931640625,
            'longitude' => 4.769039154052734
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code3()
    {
        $address = $this->bing->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"authenticationResultCode":"ValidCredentials","brandLogoUri":"http:\/\/dev.virtualearth.net\/Branding\/logo_powered_by.png","copyright":"Copyright © 2019 Microsoft and its suppliers. All rights reserved. This API cannot be accessed and the content and any results may not be used, reproduced or transmitted in any manner without express written permission from Microsoft Corporation.","resourceSets":[{"estimatedTotal":1,"resources":[{"__type":"Location:http:\/\/schemas.microsoft.com\/search\/local\/ws\/rest\/v1","bbox":[51.497010848103152,-0.15149181543728066,51.504736283244505,-0.13494617284396934],"name":"SW1A 1AA, City of Westminster, London, United Kingdom","point":{"type":"Point","coordinates":[51.500873565673828,-0.143218994140625]},"address":{"adminDistrict":"England","adminDistrict2":"London","countryRegion":"United Kingdom","formattedAddress":"SW1A 1AA, City of Westminster, London, United Kingdom","locality":"City of Westminster","postalCode":"SW1A 1AA"},"confidence":"High","entityType":"Postcode1","geocodePoints":[{"type":"Point","coordinates":[51.500873565673828,-0.143218994140625],"calculationMethod":"Rooftop","usageTypes":["Display"]}],"matchCodes":["Good"]}]}],"statusCode":200,"statusDescription":"OK","traceId":"811749f45de04542b050f6b0a0362eec|DU00000B72|7.7.0.0|Ref A: D1BF748904BD4B3CB75D0DEEC75ED20E Ref B: DB3EDGE1622 Ref C: 2019-08-04T11:27:46Z"}')
            ]),
        ]))->find('SW1A1AA');

        $this->assertSame('https://dev.virtualearth.net/REST/v1/Locations?postalCode=SW1A1AA&key=KiDvfeMKAupV8LryymvklMJDEPJ4_04iLA2AN5Ayf4dUuwndTGlYPP3fOPFHXp0N', (string)$this->bing->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'City of Westminster',
            'municipality' => 'London',
            'province' => 'England',
            'latitude' => 51.50087356567383,
            'longitude' => -0.143218994140625
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code4()
    {
        $address = $this->bing->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"authenticationResultCode":"ValidCredentials","brandLogoUri":"http:\/\/dev.virtualearth.net\/Branding\/logo_powered_by.png","copyright":"Copyright © 2019 Microsoft and its suppliers. All rights reserved. This API cannot be accessed and the content and any results may not be used, reproduced or transmitted in any manner without express written permission from Microsoft Corporation.","resourceSets":[{"estimatedTotal":1,"resources":[{"__type":"Location:http:\/\/schemas.microsoft.com\/search\/local\/ws\/rest\/v1","bbox":[-37.809871673583984,144.9825439453125,-37.793891906738281,144.99375915527344],"name":"3066, Australia","point":{"type":"Point","coordinates":[-37.801864624023438,144.98814392089844]},"address":{"adminDistrict":"VIC","countryRegion":"Australia","formattedAddress":"3066, Australia","locality":"Collingwood","postalCode":"3066"},"confidence":"High","entityType":"Postcode1","geocodePoints":[{"type":"Point","coordinates":[-37.801864624023438,144.98814392089844],"calculationMethod":"Rooftop","usageTypes":["Display"]}],"matchCodes":["Good"]}]}],"statusCode":200,"statusDescription":"OK","traceId":"ae99f12b5afa41638fd2a7c0d9f128f6|DU00000B72|7.7.0.0|Ref A: 4A805B5AD30A44D08EC3A4894893F1E2 Ref B: DB3EDGE1622 Ref C: 2019-08-04T11:28:54Z"}')
            ]),
        ]))->setOptions(['countryRegion' => 'AUS'])->find('3066');

        $this->assertSame('https://dev.virtualearth.net/REST/v1/Locations?postalCode=3066&key=KiDvfeMKAupV8LryymvklMJDEPJ4_04iLA2AN5Ayf4dUuwndTGlYPP3fOPFHXp0N&countryRegion=AUS', (string)$this->bing->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Collingwood',
            'municipality' => null,
            'province' => 'VIC',
            'latitude' => -37.80186462402344,
            'longitude' => 144.98814392089844
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code5()
    {
        $address = $this->bing->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"authenticationResultCode":"ValidCredentials","brandLogoUri":"http:\/\/dev.virtualearth.net\/Branding\/logo_powered_by.png","copyright":"Copyright © 2019 Microsoft and its suppliers. All rights reserved. This API cannot be accessed and the content and any results may not be used, reproduced or transmitted in any manner without express written permission from Microsoft Corporation.","resourceSets":[{"estimatedTotal":1,"resources":[{"__type":"Location:http:\/\/schemas.microsoft.com\/search\/local\/ws\/rest\/v1","bbox":[48.845901489257813,2.2894699573516846,48.863868713378906,2.3332901000976562],"name":"75007, Paris, France","point":{"type":"Point","coordinates":[48.854621887207031,2.3130269050598145]},"address":{"adminDistrict":"IdF","adminDistrict2":"Paris","countryRegion":"France","formattedAddress":"75007, Paris, France","locality":"Paris","postalCode":"75007"},"confidence":"High","entityType":"Postcode1","geocodePoints":[{"type":"Point","coordinates":[48.854621887207031,2.3130269050598145],"calculationMethod":"Rooftop","usageTypes":["Display"]}],"matchCodes":["Good"]}]}],"statusCode":200,"statusDescription":"OK","traceId":"2941c6de7c3443baa73fcacdaddcbe22|DU00000B72|7.7.0.0|Ref A: 595018D71A4B43EA98B79B9BA5959581 Ref B: DB3EDGE1622 Ref C: 2019-08-04T11:30:25Z"}')
            ]),
        ]))->setOptions(['countryRegion' => 'FR'])->find('75007');

        $this->assertSame('https://dev.virtualearth.net/REST/v1/Locations?postalCode=75007&key=KiDvfeMKAupV8LryymvklMJDEPJ4_04iLA2AN5Ayf4dUuwndTGlYPP3fOPFHXp0N&countryRegion=FR', (string)$this->bing->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Paris',
            'municipality' => 'Paris',
            'province' => 'IdF',
            'latitude' => 48.85462188720703,
            'longitude' => 2.3130269050598145
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code6()
    {
        $address = $this->bing->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"authenticationResultCode":"ValidCredentials","brandLogoUri":"http:\/\/dev.virtualearth.net\/Branding\/logo_powered_by.png","copyright":"Copyright © 2019 Microsoft and its suppliers. All rights reserved. This API cannot be accessed and the content and any results may not be used, reproduced or transmitted in any manner without express written permission from Microsoft Corporation.","resourceSets":[{"estimatedTotal":1,"resources":[{"__type":"Location:http:\/\/schemas.microsoft.com\/search\/local\/ws\/rest\/v1","bbox":[50.796268463134766,4.3375401496887207,50.878200531005859,4.4009099006652832],"name":"1000, Belgium","point":{"type":"Point","coordinates":[50.8553581237793,4.3508849143981934]},"address":{"adminDistrict":"Brussels Region","adminDistrict2":"Brussels Region","countryRegion":"Belgium","formattedAddress":"1000, Belgium","locality":"Brussels","postalCode":"1000"},"confidence":"High","entityType":"Postcode1","geocodePoints":[{"type":"Point","coordinates":[50.8553581237793,4.3508849143981934],"calculationMethod":"Rooftop","usageTypes":["Display"]}],"matchCodes":["Good"]}]}],"statusCode":200,"statusDescription":"OK","traceId":"51751699031a42378bbdfff2b7bffe88|DU00000B72|7.7.0.0|Ref A: A3054B749E114BD284A5014A09A6A975 Ref B: DB3EDGE1516 Ref C: 2019-08-04T11:31:56Z"}')
            ]),
        ]))->setOptions(['countryRegion' => 'BE'])->find('1000');

        $this->assertSame('https://dev.virtualearth.net/REST/v1/Locations?postalCode=1000&key=KiDvfeMKAupV8LryymvklMJDEPJ4_04iLA2AN5Ayf4dUuwndTGlYPP3fOPFHXp0N&countryRegion=BE', (string)$this->bing->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Brussels',
            'municipality' => 'Brussels Region',
            'province' => 'Brussels Region',
            'latitude' => 50.8553581237793,
            'longitude' => 4.350884914398193
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code7()
    {
        $address = $this->bing->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"authenticationResultCode":"ValidCredentials","brandLogoUri":"http:\/\/dev.virtualearth.net\/Branding\/logo_powered_by.png","copyright":"Copyright © 2019 Microsoft and its suppliers. All rights reserved. This API cannot be accessed and the content and any results may not be used, reproduced or transmitted in any manner without express written permission from Microsoft Corporation.","resourceSets":[{"estimatedTotal":1,"resources":[{"__type":"Location:http:\/\/schemas.microsoft.com\/search\/local\/ws\/rest\/v1","bbox":[52.523658752441406,13.365650177001953,52.540210723876953,13.401020050048828],"name":"10115, BE, Germany","point":{"type":"Point","coordinates":[52.532985687255859,13.377218246459961]},"address":{"adminDistrict":"BE","adminDistrict2":"Stadt Berlin","countryRegion":"Germany","formattedAddress":"10115, BE, Germany","locality":"Berlin","postalCode":"10115"},"confidence":"High","entityType":"Postcode1","geocodePoints":[{"type":"Point","coordinates":[52.532985687255859,13.377218246459961],"calculationMethod":"Rooftop","usageTypes":["Display"]}],"matchCodes":["Good"]}]}],"statusCode":200,"statusDescription":"OK","traceId":"ffbd35ca81134903b2ec3813c507ee66|DU00000B72|7.7.0.0|Ref A: 238E5BD6D9A04F369DC1524C8B352173 Ref B: DB3EDGE1622 Ref C: 2019-08-04T11:33:42Z"}')
            ]),
        ]))->setOptions(['countryRegion' => 'DE'])->find('10115');

        $this->assertSame('https://dev.virtualearth.net/REST/v1/Locations?postalCode=10115&key=KiDvfeMKAupV8LryymvklMJDEPJ4_04iLA2AN5Ayf4dUuwndTGlYPP3fOPFHXp0N&countryRegion=DE', (string)$this->bing->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Berlin',
            'municipality' => 'Stadt Berlin',
            'province' => 'BE',
            'latitude' => 52.53298568725586,
            'longitude' => 13.377218246459961
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code8()
    {
        $address = $this->bing->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"authenticationResultCode":"ValidCredentials","brandLogoUri":"http:\/\/dev.virtualearth.net\/Branding\/logo_powered_by.png","copyright":"Copyright © 2019 Microsoft and its suppliers. All rights reserved. This API cannot be accessed and the content and any results may not be used, reproduced or transmitted in any manner without express written permission from Microsoft Corporation.","resourceSets":[{"estimatedTotal":1,"resources":[{"__type":"Location:http:\/\/schemas.microsoft.com\/search\/local\/ws\/rest\/v1","bbox":[48.199600219726563,16.355119705200195,48.218589782714844,16.384939193725586],"name":"1010, Austria","point":{"type":"Point","coordinates":[48.209075927734375,16.369613647460937]},"address":{"adminDistrict":"Vienna","adminDistrict2":"Vienna","countryRegion":"Austria","formattedAddress":"1010, Austria","locality":"Vienna","postalCode":"1010"},"confidence":"High","entityType":"Postcode1","geocodePoints":[{"type":"Point","coordinates":[48.209075927734375,16.369613647460937],"calculationMethod":"Rooftop","usageTypes":["Display"]}],"matchCodes":["Good"]}]}],"statusCode":200,"statusDescription":"OK","traceId":"a3dc10a3b5c04cfa86e8f548f21f8890|DU00000B72|7.7.0.0|Ref A: BBE73685E9554E429C857845D5B338CB Ref B: DB3EDGE1622 Ref C: 2019-08-04T11:35:30Z"}')
            ]),
        ]))->setOptions(['countryRegion' => 'AT'])->find('1010');

        $this->assertSame('https://dev.virtualearth.net/REST/v1/Locations?postalCode=1010&key=KiDvfeMKAupV8LryymvklMJDEPJ4_04iLA2AN5Ayf4dUuwndTGlYPP3fOPFHXp0N&countryRegion=AT', (string)$this->bing->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Vienna',
            'municipality' => 'Vienna',
            'province' => 'Vienna',
            'latitude' => 48.209075927734375,
            'longitude' => 16.369613647460938
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_an_invalid_postal_code()
    {
        $address = $this->bing->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"authenticationResultCode":"ValidCredentials","brandLogoUri":"http:\/\/dev.virtualearth.net\/Branding\/logo_powered_by.png","copyright":"Copyright © 2019 Microsoft and its suppliers. All rights reserved. This API cannot be accessed and the content and any results may not be used, reproduced or transmitted in any manner without express written permission from Microsoft Corporation.","resourceSets":[{"estimatedTotal":0,"resources":[]}],"statusCode":200,"statusDescription":"OK","traceId":"773f48a41f614865871fbeaecce30f77|DU00000B72|7.7.0.0|Ref A: 5DD661462F6E4E55969F5D7A96F7AB94 Ref B: DB3EDGE1622 Ref C: 2019-08-04T11:36:42Z"}')
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

        $this->bing->findByPostcodeAndHouseNumber('1118CP', '202');
    }
}
