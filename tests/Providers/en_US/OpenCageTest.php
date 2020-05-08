<?php

namespace nickurt\PostcodeApi\Tests\Providers\en_US;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Exception\NotSupportedException;
use nickurt\PostcodeApi\Providers\en_US\OpenCage;
use nickurt\PostcodeApi\Tests\Providers\BaseProviderTest;

class OpenCageTest extends BaseProviderTest
{
    /** @var OpenCage */
    protected $openCage;

    public function setUp(): void
    {
        $this->openCage = (new OpenCage())
            ->setRequestUrl('https://api.opencagedata.com/geocode/v1/json')
            ->setApiKey('accy714xtv4ggfj0t7cpzvmznj0x3epk');
    }

    /** @test */
    public function it_can_get_the_default_config_values_for_this_provider()
    {
        $this->assertSame('accy714xtv4ggfj0t7cpzvmznj0x3epk', $this->openCage->getApiKey());
        $this->assertSame('https://api.opencagedata.com/geocode/v1/json', $this->openCage->getRequestUrl());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        $address = $this->openCage->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"documentation":"https://opencagedata.com/api","licenses":[{"name":"see attribution guide","url":"https://opencagedata.com/credits"}],"rate":{"limit":2500,"remaining":2495,"reset":1577059200},"results":[{"annotations":{"DMS":{"lat":"33\u00b0 45\' 58.61304\'\' N","lng":"116\u00b0 27\' 6.93648\'\' W"},"FIPS":{"state":"06"},"MGRS":"11SNT5075136377","Maidenhead":"DM13ss53sv","Mercator":{"x":-12963369.189,"y":3973714.315},"OSM":{"url":"https://www.openstreetmap.org/?mlat=33.76628&mlon=-116.45193#map=16/33.76628/-116.45193"},"UN_M49":{"regions":{"AMERICAS":"019","NORTHERN_AMERICA":"021","US":"840","WORLD":"001"},"statistical_groupings":["MEDC"]},"callingcode":1,"currency":{"alternate_symbols":["US$"],"decimal_mark":".","disambiguate_symbol":"US$","html_entity":"$","iso_code":"USD","iso_numeric":"840","name":"United States Dollar","smallest_denomination":1,"subunit":"Cent","subunit_to_unit":100,"symbol":"$","symbol_first":1,"thousands_separator":","},"flag":"\ud83c\uddfa\ud83c\uddf8","geohash":"9qj0n4fqc7jf6kvu0p3r","qibla":25.72,"roadinfo":{"drive_on":"right","speed_in":"mph"},"sun":{"rise":{"apparent":1577026080,"astronomical":1577020740,"civil":1577024400,"nautical":1577022540},"set":{"apparent":1576975260,"astronomical":1576980600,"civil":1576976940,"nautical":1576978800}},"timezone":{"name":"America/Los_Angeles","now_in_dst":0,"offset_sec":-28800,"offset_string":"-0800","short_name":"PST"},"what3words":{"words":"offhand.laws.debater"}},"bounds":{"northeast":{"lat":33.7663314,"lng":-116.4518768},"southwest":{"lat":33.7662314,"lng":-116.4519768}},"components":{"ISO_3166-1_alpha-2":"US","ISO_3166-1_alpha-3":"USA","_type":"city","city":"Rancho Mirage","continent":"North America","country":"USA","country_code":"us","postcode":"92270","state":"California","state_code":"CA"},"confidence":9,"formatted":"Rancho Mirage, CA 92270, United States of America","geometry":{"lat":33.7662814,"lng":-116.4519268}},{"annotations":{"DMS":{"lat":"33\u00b0 45\' 51.48000\'\' N","lng":"116\u00b0 25\' 21.00000\'\' W"},"FIPS":{"county":"06065","state":"06"},"MGRS":"11SNT5347836172","Maidenhead":"DM13ss93hk","Mercator":{"x":-12960093.417,"y":3973450.221},"OSM":{"url":"https://www.openstreetmap.org/?mlat=33.76430&mlon=-116.42250#map=16/33.76430/-116.42250"},"UN_M49":{"regions":{"AMERICAS":"019","NORTHERN_AMERICA":"021","US":"840","WORLD":"001"},"statistical_groupings":["MEDC"]},"callingcode":1,"currency":{"alternate_symbols":["US$"],"decimal_mark":".","disambiguate_symbol":"US$","html_entity":"$","iso_code":"USD","iso_numeric":"840","name":"United States Dollar","smallest_denomination":1,"subunit":"Cent","subunit_to_unit":100,"symbol":"$","symbol_first":1,"thousands_separator":","},"flag":"\ud83c\uddfa\ud83c\uddf8","geohash":"9qj0ndxer1snb66fmt8z","qibla":25.75,"roadinfo":{"drive_on":"right","speed_in":"mph"},"sun":{"rise":{"apparent":1577026080,"astronomical":1577020740,"civil":1577024400,"nautical":1577022540},"set":{"apparent":1576975260,"astronomical":1576980600,"civil":1576976940,"nautical":1576978800}},"timezone":{"name":"America/Los_Angeles","now_in_dst":0,"offset_sec":-28800,"offset_string":"-0800","short_name":"PST"},"what3words":{"words":"bridge.gulped.variety"}},"bounds":{"northeast":{"lat":33.836344,"lng":-116.388151},"southwest":{"lat":33.713622,"lng":-116.477924}},"components":{"ISO_3166-1_alpha-2":"US","ISO_3166-1_alpha-3":"USA","_type":"county","continent":"North America","country":"United States of America","country_code":"us","county":"Riverside County","postcode":"92270","state":"California","state_code":"CA"},"confidence":6,"formatted":"Riverside County, CA 92270, United States of America","geometry":{"lat":33.7643,"lng":-116.4225}}],"status":{"code":200,"message":"OK"},"stay_informed":{"blog":"https://blog.opencagedata.com","twitter":"https://twitter.com/opencagedata"},"thanks":"For using an OpenCage API","timestamp":{"created_http":"Sun, 22 Dec 2019 11:07:44 GMT","created_unix":1577012864},"total_results":2}')
            ])
        ]))->setOptions(['countrycode' => 'us'])->find('92270');

        $this->assertSame('https://api.opencagedata.com/geocode/v1/json?q=92270&key=accy714xtv4ggfj0t7cpzvmznj0x3epk&countrycode=us', $this->openCage->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Rancho Mirage',
            'municipality' => 'USA',
            'province' => 'California',
            'latitude' => 33.7662814,
            'longitude' => -116.4519268
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code2()
    {
        $address = $this->openCage->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"documentation":"https://opencagedata.com/api","licenses":[{"name":"see attribution guide","url":"https://opencagedata.com/credits"}],"rate":{"limit":2500,"remaining":2494,"reset":1577059200},"results":[{"annotations":{"DMS":{"lat":"52\u00b0 18\' 12.75012\'\' N","lng":"4\u00b0 44\' 50.65368\'\' E"},"MGRS":"31UFT1914296237","Maidenhead":"JO22ih92qu","Mercator":{"x":528478.575,"y":6821364.532},"OSM":{"url":"https://www.openstreetmap.org/?mlat=52.30354&mlon=4.74740#map=16/52.30354/4.74740"},"UN_M49":{"regions":{"EUROPE":"150","NL":"528","WESTERN_EUROPE":"155","WORLD":"001"},"statistical_groupings":["MEDC"]},"callingcode":31,"currency":{"alternate_symbols":[],"decimal_mark":",","html_entity":"&#x20AC;","iso_code":"EUR","iso_numeric":"978","name":"Euro","smallest_denomination":1,"subunit":"Cent","subunit_to_unit":100,"symbol":"\u20ac","symbol_first":1,"thousands_separator":"."},"flag":"\ud83c\uddf3\ud83c\uddf1","geohash":"u173s18fnwbg5mj56hdt","qibla":125.35,"roadinfo":{"drive_on":"right","speed_in":"km/h"},"sun":{"rise":{"apparent":1577000940,"astronomical":1576993380,"civil":1576998480,"nautical":1576995840},"set":{"apparent":1577028540,"astronomical":1577036160,"civil":1577031060,"nautical":1577033700}},"timezone":{"name":"Europe/Amsterdam","now_in_dst":0,"offset_sec":3600,"offset_string":"+0100","short_name":"CET"},"what3words":{"words":"cups.bike.trumpet"}},"bounds":{"northeast":{"lat":52.3035917,"lng":4.7474538},"southwest":{"lat":52.3034917,"lng":4.7473538}},"components":{"ISO_3166-1_alpha-2":"NL","ISO_3166-1_alpha-3":"NLD","_type":"neighbourhood","city":"Haarlemmermeer","continent":"Europe","country":"The Netherlands","country_code":"nl","political_union":"European Union","postcode":"1118CP","state":"North Holland","suburb":"Schiphol"},"confidence":9,"formatted":"1118CP Haarlemmermeer, The Netherlands","geometry":{"lat":52.3035417,"lng":4.7474038}}],"status":{"code":200,"message":"OK"},"stay_informed":{"blog":"https://blog.opencagedata.com","twitter":"https://twitter.com/opencagedata"},"thanks":"For using an OpenCage API","timestamp":{"created_http":"Sun, 22 Dec 2019 11:19:54 GMT","created_unix":1577013594},"total_results":1}')
            ]),
        ]))->setOptions(['countrycode' => 'nl'])->find('1118CP');

        $this->assertSame('https://api.opencagedata.com/geocode/v1/json?q=1118CP&key=accy714xtv4ggfj0t7cpzvmznj0x3epk&countrycode=nl', $this->openCage->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Haarlemmermeer',
            'municipality' => 'The Netherlands',
            'province' => 'North Holland',
            'latitude' => 52.3035417,
            'longitude' => 4.7474038
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code3()
    {
        $address = $this->openCage->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"documentation":"https://opencagedata.com/api","licenses":[{"name":"see attribution guide","url":"https://opencagedata.com/credits"}],"rate":{"limit":2500,"remaining":2493,"reset":1577059200},"results":[{"annotations":{"DMS":{"lat":"51\u00b0 30\' 3.63240\'\' N","lng":"0\u00b0 8\' 29.71680\'\' E"},"MGRS":"30UXC9838709415","Maidenhead":"IO91wm30af","Mercator":{"x":-15761.504,"y":6676937.718},"OSM":{"url":"https://www.openstreetmap.org/?mlat=51.50101&mlon=-0.14159#map=16/51.50101/-0.14159"},"UN_M49":{"regions":{"EUROPE":"150","GB":"826","NORTHERN_EUROPE":"154","WORLD":"001"},"statistical_groupings":["MEDC"]},"callingcode":44,"currency":{"alternate_symbols":[],"decimal_mark":".","html_entity":"&#x00A3;","iso_code":"GBP","iso_numeric":"826","name":"British Pound","smallest_denomination":1,"subunit":"Penny","subunit_to_unit":100,"symbol":"\u00a3","symbol_first":1,"thousands_separator":","},"flag":"\ud83c\uddec\ud83c\udde7","geohash":"gcpuuz2zhgbm4xrhn6gt","qibla":118.97,"roadinfo":{"drive_on":"left","speed_in":"mph"},"sun":{"rise":{"apparent":1577001900,"astronomical":1576994460,"civil":1576999500,"nautical":1576996860},"set":{"apparent":1577029980,"astronomical":1577037420,"civil":1577032380,"nautical":1577035020}},"timezone":{"name":"Europe/London","now_in_dst":0,"offset_sec":0,"offset_string":"+0000","short_name":"GMT"},"what3words":{"words":"plus.escape.yarn"}},"components":{"ISO_3166-1_alpha-2":"GB","ISO_3166-1_alpha-3":"GBR","_type":"postcode","city":"London","continent":"Europe","country":"United Kingdom","country_code":"gb","county":"Westminster","county_code":"WSM","political_union":"European Union","postcode":"SW1A 1AA","state":"England","state_code":"ENG","suburb":"St James\'s"},"confidence":10,"formatted":"London SW1A 1AA, United Kingdom","geometry":{"lat":51.501009,"lng":-0.141588}}],"status":{"code":200,"message":"OK"},"stay_informed":{"blog":"https://blog.opencagedata.com","twitter":"https://twitter.com/opencagedata"},"thanks":"For using an OpenCage API","timestamp":{"created_http":"Sun, 22 Dec 2019 11:23:01 GMT","created_unix":1577013781},"total_results":1}')
            ]),
        ]))->find('SW1A1AA');

        $this->assertSame('https://api.opencagedata.com/geocode/v1/json?q=SW1A1AA&key=accy714xtv4ggfj0t7cpzvmznj0x3epk', $this->openCage->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'London',
            'municipality' => 'United Kingdom',
            'province' => 'England',
            'latitude' => 51.501009,
            'longitude' => -0.141588
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code4()
    {
        $address = $this->openCage->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"documentation":"https://opencagedata.com/api","licenses":[{"name":"see attribution guide","url":"https://opencagedata.com/credits"}],"rate":{"limit":2500,"remaining":2492,"reset":1577059200},"results":[{"annotations":{"DMS":{"lat":"37\u00b0 48\' 4.88880\'\' S","lng":"144\u00b0 59\' 7.02708\'\' E"},"MGRS":"55HCU2262814312","Maidenhead":"QF22le87fq","Mercator":{"x":16139688.132,"y":-4525209.771},"OSM":{"edit_url":"https://www.openstreetmap.org/edit?way=191186825#map=17/-37.80136/144.98529","url":"https://www.openstreetmap.org/?mlat=-37.80136&mlon=144.98529#map=17/-37.80136/144.98529"},"UN_M49":{"regions":{"AU":"036","AUSTRALASIA":"053","OCEANIA":"009","WORLD":"001"},"statistical_groupings":["MEDC"]},"callingcode":61,"currency":{"alternate_symbols":["A$"],"decimal_mark":".","disambiguate_symbol":"A$","html_entity":"$","iso_code":"AUD","iso_numeric":"036","name":"Australian Dollar","smallest_denomination":5,"subunit":"Cent","subunit_to_unit":100,"symbol":"$","symbol_first":1,"thousands_separator":","},"flag":"\ud83c\udde6\ud83c\uddfa","geohash":"r1r0gnrp4h07gu191pqc","qibla":278.82,"roadinfo":{"drive_on":"left","speed_in":"km/h"},"sun":{"rise":{"apparent":1577040960,"astronomical":1577034060,"civil":1577039040,"nautical":1577036700},"set":{"apparent":1577007660,"astronomical":1577014560,"civil":1577009520,"nautical":1577011860}},"timezone":{"name":"Australia/Melbourne","now_in_dst":1,"offset_sec":39600,"offset_string":"+1100","short_name":"AEDT"},"what3words":{"words":"radio.hired.cities"}},"bounds":{"northeast":{"lat":-37.8011958,"lng":144.9854287},"southwest":{"lat":-37.8014414,"lng":144.9851557}},"components":{"ISO_3166-1_alpha-2":"AU","ISO_3166-1_alpha-3":"AUS","_type":"neighbourhood","continent":"Oceania","country":"Australia","country_code":"au","county":"City of Yarra","postcode":"3066","state":"Victoria","state_code":"VIC","suburb":"Collingwood"},"confidence":9,"formatted":"Collingwood VIC 3066, Australia","geometry":{"lat":-37.801358,"lng":144.9852853}},{"annotations":{"DMS":{"lat":"33\u00b0 9\' 28.84140\'\' S","lng":"143\u00b0 18\' 42.54300\'\' E"},"MGRS":"54HYJ1559828815","Maidenhead":"QF16pu72kb","Mercator":{"x":15953398.548,"y":-3892927.085},"OSM":{"url":"https://www.openstreetmap.org/?mlat=-33.15801&mlon=143.31182#map=17/-33.15801/143.31182"},"UN_M49":{"regions":{"AU":"036","AUSTRALASIA":"053","OCEANIA":"009","WORLD":"001"},"statistical_groupings":["MEDC"]},"callingcode":61,"currency":{"alternate_symbols":["A$"],"decimal_mark":".","disambiguate_symbol":"A$","html_entity":"$","iso_code":"AUD","iso_numeric":"036","name":"Australian Dollar","smallest_denomination":5,"subunit":"Cent","subunit_to_unit":100,"symbol":"$","symbol_first":1,"thousands_separator":","},"flag":"\ud83c\udde6\ud83c\uddfa","geohash":"r4jgm5u2x6skf6xzp38t","qibla":281.67,"roadinfo":{"drive_on":"left","speed_in":"km/h"},"sun":{"rise":{"apparent":1577042100,"astronomical":1577035980,"civil":1577040420,"nautical":1577038260},"set":{"apparent":1577007240,"astronomical":1577013420,"civil":1577008980,"nautical":1577011080}},"timezone":{"name":"Australia/Sydney","now_in_dst":1,"offset_sec":39600,"offset_string":"+1100","short_name":"AEDT"},"what3words":{"words":"flats.implicitly.enlisting"}},"components":{"ISO_3166-1_alpha-2":"AU","ISO_3166-1_alpha-3":"AUS","_type":"building","city":"PAN BAN","continent":"Oceania","country":"Australia","country_code":"au","house_number":3066,"postcode":"2648","state":"NEW SOUTH WALES","state_code":"NSW","street":"IVANHOE RD"},"confidence":10,"formatted":"3066 IVANHOE RD, PAN BAN NSW 2648, Australia","geometry":{"lat":-33.1580115,"lng":143.3118175}},{"annotations":{"DMS":{"lat":"37\u00b0 47\' 60.00000\'\' S","lng":"144\u00b0 58\' 59.88000\'\' E"},"MGRS":"55HCU2245014459","Maidenhead":"QF22le78xa","Mercator":{"x":16139467.13,"y":-4525019.245},"OSM":{"url":"https://www.openstreetmap.org/?mlat=-37.80000&mlon=144.98330#map=17/-37.80000/144.98330"},"UN_M49":{"regions":{"AU":"036","AUSTRALASIA":"053","OCEANIA":"009","WORLD":"001"},"statistical_groupings":["MEDC"]},"callingcode":61,"currency":{"alternate_symbols":["A$"],"decimal_mark":".","disambiguate_symbol":"A$","html_entity":"$","iso_code":"AUD","iso_numeric":"036","name":"Australian Dollar","smallest_denomination":5,"subunit":"Cent","subunit_to_unit":100,"symbol":"$","symbol_first":1,"thousands_separator":","},"flag":"\ud83c\udde6\ud83c\uddfa","geohash":"r1r0gntx5c20bwwrj9q1","qibla":278.82,"roadinfo":{"drive_on":"left","speed_in":"km/h"},"sun":{"rise":{"apparent":1577040960,"astronomical":1577034060,"civil":1577039040,"nautical":1577036700},"set":{"apparent":1577007660,"astronomical":1577014560,"civil":1577009520,"nautical":1577011860}},"timezone":{"name":"Australia/Melbourne","now_in_dst":1,"offset_sec":39600,"offset_string":"+1100","short_name":"AEDT"},"what3words":{"words":"placed.will.lots"}},"components":{"ISO_3166-1_alpha-2":"AU","ISO_3166-1_alpha-3":"AUS","_type":"postcode","continent":"Oceania","country":"Australia","country_code":"au","postcode":"3066"},"confidence":7,"formatted":"3066, Australia","geometry":{"lat":-37.8,"lng":144.9833}}],"status":{"code":200,"message":"OK"},"stay_informed":{"blog":"https://blog.opencagedata.com","twitter":"https://twitter.com/opencagedata"},"thanks":"For using an OpenCage API","timestamp":{"created_http":"Sun, 22 Dec 2019 11:24:49 GMT","created_unix":1577013889},"total_results":3}')
            ]),
        ]))->setOptions(['countrycode' => 'au'])->find('3066');

        $this->assertSame('https://api.opencagedata.com/geocode/v1/json?q=3066&key=accy714xtv4ggfj0t7cpzvmznj0x3epk&countrycode=au', $this->openCage->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Collingwood',
            'municipality' => 'Australia',
            'province' => 'Victoria',
            'latitude' => -37.801358,
            'longitude' => 144.9852853
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code5()
    {
        $address = $this->openCage->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"documentation":"https://opencagedata.com/api","licenses":[{"name":"see attribution guide","url":"https://opencagedata.com/credits"}],"rate":{"limit":2500,"remaining":2491,"reset":1577059200},"results":[{"annotations":{"DMS":{"lat":"48\u00b0 51\' 21.40452\'\' N","lng":"2\u00b0 18\' 44.57808\'\' E"},"MGRS":"31UDQ4956111670","Maidenhead":"JN18du75lk","Mercator":{"x":257413.276,"y":6218259.062},"OSM":{"edit_url":"https://www.openstreetmap.org/edit?way=643343004#map=17/48.85595/2.31238","url":"https://www.openstreetmap.org/?mlat=48.85595&mlon=2.31238#map=17/48.85595/2.31238"},"UN_M49":{"regions":{"EUROPE":"150","FR":"250","WESTERN_EUROPE":"155","WORLD":"001"},"statistical_groupings":["MEDC"]},"callingcode":33,"currency":{"alternate_symbols":[],"decimal_mark":",","html_entity":"&#x20AC;","iso_code":"EUR","iso_numeric":"978","name":"Euro","smallest_denomination":1,"subunit":"Cent","subunit_to_unit":100,"symbol":"\u20ac","symbol_first":1,"thousands_separator":"."},"flag":"\ud83c\uddeb\ud83c\uddf7","geohash":"u09tutgyd2ms6ept89t8","qibla":119.12,"roadinfo":{"drive_on":"right","speed_in":"km/h"},"sun":{"rise":{"apparent":1577000520,"astronomical":1576993560,"civil":1576998300,"nautical":1576995900},"set":{"apparent":1577030160,"astronomical":1577037120,"civil":1577032380,"nautical":1577034780}},"timezone":{"name":"Europe/Paris","now_in_dst":0,"offset_sec":3600,"offset_string":"+0100","short_name":"CET"},"what3words":{"words":"scouted.melons.curious"}},"bounds":{"northeast":{"lat":48.8571924,"lng":2.3144774},"southwest":{"lat":48.8547329,"lng":2.3101504}},"components":{"ISO_3166-1_alpha-2":"FR","ISO_3166-1_alpha-3":"FRA","_type":"neighbourhood","city":"Paris","city_district":"7th Arrondissement","continent":"Europe","country":"France","country_code":"fr","county":"Paris","political_union":"European Union","postcode":"75007","state":"Ile-de-France","state_district":"Paris","suburb":"Invalides"},"confidence":9,"formatted":"75007 Paris, France","geometry":{"lat":48.8559457,"lng":2.3123828}},{"annotations":{"DMS":{"lat":"48\u00b0 51\' 21.34224\'\' N","lng":"2\u00b0 18\' 49.84524\'\' E"},"MGRS":"31UDQ4966811667","Maidenhead":"JN18du75pk","Mercator":{"x":257576.144,"y":6218256.142},"OSM":{"url":"https://www.openstreetmap.org/?mlat=48.85593&mlon=2.31385#map=17/48.85593/2.31385"},"UN_M49":{"regions":{"EUROPE":"150","FR":"250","WESTERN_EUROPE":"155","WORLD":"001"},"statistical_groupings":["MEDC"]},"callingcode":33,"currency":{"alternate_symbols":[],"decimal_mark":",","html_entity":"&#x20AC;","iso_code":"EUR","iso_numeric":"978","name":"Euro","smallest_denomination":1,"subunit":"Cent","subunit_to_unit":100,"symbol":"\u20ac","symbol_first":1,"thousands_separator":"."},"flag":"\ud83c\uddeb\ud83c\uddf7","geohash":"u09tutuykt0t149tt6fb","qibla":119.12,"roadinfo":{"drive_on":"right","speed_in":"km/h"},"sun":{"rise":{"apparent":1577000520,"astronomical":1576993560,"civil":1576998300,"nautical":1576995900},"set":{"apparent":1577030160,"astronomical":1577037120,"civil":1577032380,"nautical":1577034780}},"timezone":{"name":"Europe/Paris","now_in_dst":0,"offset_sec":3600,"offset_string":"+0100","short_name":"CET"},"what3words":{"words":"fewest.flap.thumps"}},"bounds":{"northeast":{"lat":48.8559784,"lng":2.3138959},"southwest":{"lat":48.8558784,"lng":2.3137959}},"components":{"ISO_3166-1_alpha-2":"FR","ISO_3166-1_alpha-3":"FRA","_type":"neighbourhood","continent":"Europe","country":"France","country_code":"fr","political_union":"European Union","postcode":"75007","state":"Ile-de-France","state_district":"Invalides","suburb":"Invalides"},"confidence":9,"formatted":"75007 Ile-de-France, France","geometry":{"lat":48.8559284,"lng":2.3138459}},{"annotations":{"DMS":{"lat":"48\u00b0 51\' 23.40000\'\' N","lng":"2\u00b0 19\' 15.60000\'\' E"},"MGRS":"31UDQ5019311726","Maidenhead":"JN18du85mn","Mercator":{"x":258372.538,"y":6218352.563},"OSM":{"url":"https://www.openstreetmap.org/?mlat=48.85650&mlon=2.32100#map=17/48.85650/2.32100"},"UN_M49":{"regions":{"EUROPE":"150","FR":"250","WESTERN_EUROPE":"155","WORLD":"001"},"statistical_groupings":["MEDC"]},"callingcode":33,"currency":{"alternate_symbols":[],"decimal_mark":",","html_entity":"&#x20AC;","iso_code":"EUR","iso_numeric":"978","name":"Euro","smallest_denomination":1,"subunit":"Cent","subunit_to_unit":100,"symbol":"\u20ac","symbol_first":1,"thousands_separator":"."},"flag":"\ud83c\uddeb\ud83c\uddf7","geohash":"u09tuy41epxn94w11e0r","qibla":119.13,"roadinfo":{"drive_on":"right","speed_in":"km/h"},"sun":{"rise":{"apparent":1577000520,"astronomical":1576993560,"civil":1576998300,"nautical":1576995900},"set":{"apparent":1577030160,"astronomical":1577037120,"civil":1577032380,"nautical":1577034780}},"timezone":{"name":"Europe/Paris","now_in_dst":0,"offset_sec":3600,"offset_string":"+0100","short_name":"CET"},"what3words":{"words":"expanded.ready.laying"}},"components":{"ISO_3166-1_alpha-2":"FR","ISO_3166-1_alpha-3":"FRA","_type":"county","continent":"Europe","country":"France","country_code":"fr","county":"Paris","local_administrative_area":"Paris","political_union":"European Union","postcode":"75007","state":"\u00cele-de-France","state_code":"IDF"},"confidence":9,"formatted":"75007 \u00cele-de-France, France","geometry":{"lat":48.8565,"lng":2.321}}],"status":{"code":200,"message":"OK"},"stay_informed":{"blog":"https://blog.opencagedata.com","twitter":"https://twitter.com/opencagedata"},"thanks":"For using an OpenCage API","timestamp":{"created_http":"Sun, 22 Dec 2019 11:27:39 GMT","created_unix":1577014059},"total_results":3}')
            ]),
        ]))->setOptions(['countrycode' => 'fr'])->find('75007');

        $this->assertSame('https://api.opencagedata.com/geocode/v1/json?q=75007&key=accy714xtv4ggfj0t7cpzvmznj0x3epk&countrycode=fr', $this->openCage->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Paris',
            'municipality' => 'France',
            'province' => 'Ile-de-France',
            'latitude' => 48.8559457,
            'longitude' => 2.3123828
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code6()
    {
        $address = $this->openCage->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"documentation":"https://opencagedata.com/api","licenses":[{"name":"see attribution guide","url":"https://opencagedata.com/credits"}],"rate":{"limit":2500,"remaining":2490,"reset":1577059200},"results":[{"annotations":{"DMS":{"lat":"50\u00b0 50\' 43.77552\'\' N","lng":"4\u00b0 22\' 8.19120\'\' E"},"MGRS":"31UES9637433536","Maidenhead":"JO20eu42gw","Mercator":{"x":486348.394,"y":6560854.345},"OSM":{"edit_url":"https://www.openstreetmap.org/edit?way=396533093#map=17/50.84549/4.36894","url":"https://www.openstreetmap.org/?mlat=50.84549&mlon=4.36894#map=17/50.84549/4.36894"},"UN_M49":{"regions":{"BE":"056","EUROPE":"150","WESTERN_EUROPE":"155","WORLD":"001"},"statistical_groupings":["MEDC"]},"callingcode":32,"currency":{"alternate_symbols":[],"decimal_mark":",","html_entity":"&#x20AC;","iso_code":"EUR","iso_numeric":"978","name":"Euro","smallest_denomination":1,"subunit":"Cent","subunit_to_unit":100,"symbol":"\u20ac","symbol_first":1,"thousands_separator":"."},"flag":"\ud83c\udde7\ud83c\uddea","geohash":"u15172jk7wzhzefvrxfz","qibla":123.5,"roadinfo":{"drive_on":"right","speed_in":"km/h"},"sun":{"rise":{"apparent":1577000580,"astronomical":1576993320,"civil":1576998240,"nautical":1576995720},"set":{"apparent":1577029080,"astronomical":1577036400,"civil":1577031480,"nautical":1577034000}},"timezone":{"name":"Europe/Brussels","now_in_dst":0,"offset_sec":3600,"offset_string":"+0100","short_name":"CET"},"what3words":{"words":"dabble.milder.issued"},"wikidata":"Q893211"},"bounds":{"northeast":{"lat":50.8459437,"lng":4.3696763},"southwest":{"lat":50.8450652,"lng":4.3679111}},"components":{"ISO_3166-1_alpha-2":"BE","ISO_3166-1_alpha-3":"BEL","_type":"neighbourhood","city":"Ville de Bruxelles - Stad Brussel","city_district":"Brussels","continent":"Europe","country":"Belgium","country_code":"be","county":"Brussels-Capital","political_union":"European Union","postcode":"1000","state":"Brussels-Capital","suburb":"European Quarter"},"confidence":9,"formatted":"1000 Ville de Bruxelles - Stad Brussel, Belgium","geometry":{"lat":50.8454932,"lng":4.368942}},{"annotations":{"DMS":{"lat":"50\u00b0 50\' 47.76000\'\' N","lng":"4\u00b0 21\' 10.08000\'\' E"},"MGRS":"31UES9523633638","Maidenhead":"JO20eu23ie","Mercator":{"x":484551.48,"y":6561048.964},"OSM":{"url":"https://www.openstreetmap.org/?mlat=50.84660&mlon=4.35280#map=17/50.84660/4.35280"},"UN_M49":{"regions":{"BE":"056","EUROPE":"150","WESTERN_EUROPE":"155","WORLD":"001"},"statistical_groupings":["MEDC"]},"callingcode":32,"currency":{"alternate_symbols":[],"decimal_mark":",","html_entity":"&#x20AC;","iso_code":"EUR","iso_numeric":"978","name":"Euro","smallest_denomination":1,"subunit":"Cent","subunit_to_unit":100,"symbol":"\u20ac","symbol_first":1,"thousands_separator":"."},"flag":"\ud83c\udde7\ud83c\uddea","geohash":"u151703dgt4zmxdvg0jb","qibla":123.48,"roadinfo":{"drive_on":"right","speed_in":"km/h"},"sun":{"rise":{"apparent":1577000640,"astronomical":1576993320,"civil":1576998240,"nautical":1576995720},"set":{"apparent":1577029140,"astronomical":1577036400,"civil":1577031480,"nautical":1577034000}},"timezone":{"name":"Europe/Brussels","now_in_dst":0,"offset_sec":3600,"offset_string":"+0100","short_name":"CET"},"what3words":{"words":"cheering.multiple.pumpkin"}},"components":{"ISO_3166-1_alpha-2":"BE","ISO_3166-1_alpha-3":"BEL","_type":"postcode","continent":"Europe","country":"Belgium","country_code":"be","political_union":"European Union","postcode":"1000","state":"Brussels Capital"},"confidence":7,"formatted":"1000 Brussels Capital, Belgium","geometry":{"lat":50.8466,"lng":4.3528}}],"status":{"code":200,"message":"OK"},"stay_informed":{"blog":"https://blog.opencagedata.com","twitter":"https://twitter.com/opencagedata"},"thanks":"For using an OpenCage API","timestamp":{"created_http":"Sun, 22 Dec 2019 11:28:48 GMT","created_unix":1577014128},"total_results":2}')
            ]),
        ]))->setOptions(['countrycode' => 'be'])->find('1000');

        $this->assertSame('https://api.opencagedata.com/geocode/v1/json?q=1000&key=accy714xtv4ggfj0t7cpzvmznj0x3epk&countrycode=be', $this->openCage->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Ville de Bruxelles - Stad Brussel',
            'municipality' => 'Belgium',
            'province' => 'Brussels-Capital',
            'latitude' => 50.8454932,
            'longitude' => 4.368942
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code7()
    {
        $address = $this->openCage->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"documentation":"https://opencagedata.com/api","licenses":[{"name":"see attribution guide","url":"https://opencagedata.com/credits"}],"rate":{"limit":2500,"remaining":2489,"reset":1577059200},"results":[{"annotations":{"DMS":{"lat":"52\u00b0 31\' 45.42600\'\' N","lng":"13\u00b0 22\' 44.67036\'\' E"},"MGRS":"33UUU9004321144","Maidenhead":"JO62qm57la","Mercator":{"x":1489351.827,"y":6862463.254},"OSM":{"edit_url":"https://www.openstreetmap.org/edit?way=224397383#map=16/52.52929/13.37908","url":"https://www.openstreetmap.org/?mlat=52.52929&mlon=13.37908#map=16/52.52929/13.37908"},"UN_M49":{"regions":{"DE":"276","EUROPE":"150","WESTERN_EUROPE":"155","WORLD":"001"},"statistical_groupings":["MEDC"]},"callingcode":49,"currency":{"alternate_symbols":[],"decimal_mark":",","html_entity":"&#x20AC;","iso_code":"EUR","iso_numeric":"978","name":"Euro","smallest_denomination":1,"subunit":"Cent","subunit_to_unit":100,"symbol":"\u20ac","symbol_first":1,"thousands_separator":"."},"flag":"\ud83c\udde9\ud83c\uddea","geohash":"u33db6wm703qqxyk07mn","qibla":136.66,"roadinfo":{"drive_on":"right","speed_in":"km/h"},"sun":{"rise":{"apparent":1576998960,"astronomical":1576991280,"civil":1576996440,"nautical":1576993800},"set":{"apparent":1577026440,"astronomical":1577034060,"civil":1577028900,"nautical":1577031600}},"timezone":{"name":"Europe/Berlin","now_in_dst":0,"offset_sec":3600,"offset_string":"+0100","short_name":"CET"},"what3words":{"words":"transfers.slurred.laptop"}},"bounds":{"northeast":{"lat":52.529373,"lng":13.3791012},"southwest":{"lat":52.5291882,"lng":13.3790313}},"components":{"ISO_3166-1_alpha-2":"DE","ISO_3166-1_alpha-3":"DEU","_type":"neighbourhood","city":"Berlin","city_district":"Mitte","continent":"Europe","country":"Germany","country_code":"de","political_union":"European Union","postcode":"10115","state":"Berlin","state_code":"BE","suburb":"Mitte"},"confidence":9,"formatted":"10115 Berlin, Germany","geometry":{"lat":52.529285,"lng":13.3790751}}],"status":{"code":200,"message":"OK"},"stay_informed":{"blog":"https://blog.opencagedata.com","twitter":"https://twitter.com/opencagedata"},"thanks":"For using an OpenCage API","timestamp":{"created_http":"Sun, 22 Dec 2019 11:30:00 GMT","created_unix":1577014200},"total_results":1}')
            ]),
        ]))->setOptions(['countrycode' => 'de'])->find('10115');

        $this->assertSame('https://api.opencagedata.com/geocode/v1/json?q=10115&key=accy714xtv4ggfj0t7cpzvmznj0x3epk&countrycode=de', $this->openCage->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Berlin',
            'municipality' => 'Germany',
            'province' => 'Berlin',
            'latitude' => 52.529285,
            'longitude' => 13.3790751
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code8()
    {
        $address = $this->openCage->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"documentation":"https://opencagedata.com/api","licenses":[{"name":"see attribution guide","url":"https://opencagedata.com/credits"}],"rate":{"limit":2500,"remaining":2488,"reset":1577059200},"results":[{"annotations":{"DMS":{"lat":"48\u00b0 12\' 31.48848\'\' N","lng":"16\u00b0 22\' 14.65320\'\' E"},"MGRS":"33UXP0183640410","Maidenhead":"JN88ef40lc","Mercator":{"x":1822382.11,"y":6109779.385},"OSM":{"url":"https://www.openstreetmap.org/?mlat=48.20875&mlon=16.37074#map=16/48.20875/16.37074"},"UN_M49":{"regions":{"AT":"040","EUROPE":"150","WESTERN_EUROPE":"155","WORLD":"001"},"statistical_groupings":["MEDC"]},"callingcode":43,"currency":{"alternate_symbols":[],"decimal_mark":",","html_entity":"&#x20AC;","iso_code":"EUR","iso_numeric":"978","name":"Euro","smallest_denomination":1,"subunit":"Cent","subunit_to_unit":100,"symbol":"\u20ac","symbol_first":1,"thousands_separator":"."},"flag":"\ud83c\udde6\ud83c\uddf9","geohash":"u2edk80u3cf22umzmp91","qibla":136.71,"roadinfo":{"drive_on":"right","speed_in":"km/h"},"sun":{"rise":{"apparent":1576996980,"astronomical":1576990140,"civil":1576994820,"nautical":1576992420},"set":{"apparent":1577026920,"astronomical":1577033820,"civil":1577029140,"nautical":1577031540}},"timezone":{"name":"Europe/Vienna","now_in_dst":0,"offset_sec":3600,"offset_string":"+0100","short_name":"CET"},"what3words":{"words":"linen.vowing.released"}},"bounds":{"northeast":{"lat":48.2087968,"lng":16.370787},"southwest":{"lat":48.2086968,"lng":16.370687}},"components":{"ISO_3166-1_alpha-2":"AT","ISO_3166-1_alpha-3":"AUT","_type":"neighbourhood","continent":"Europe","country":"Austria","country_code":"at","political_union":"European Union","postcode":"1010","state":"Vienna","suburb":"KG Innere Stadt"},"confidence":9,"formatted":"1010 Vienna, Austria","geometry":{"lat":48.2087468,"lng":16.370737}}],"status":{"code":200,"message":"OK"},"stay_informed":{"blog":"https://blog.opencagedata.com","twitter":"https://twitter.com/opencagedata"},"thanks":"For using an OpenCage API","timestamp":{"created_http":"Sun, 22 Dec 2019 11:31:14 GMT","created_unix":1577014274},"total_results":1}')
            ]),
        ]))->setOptions(['countrycode' => 'at'])->find('1010');

        $this->assertSame('https://api.opencagedata.com/geocode/v1/json?q=1010&key=accy714xtv4ggfj0t7cpzvmznj0x3epk&countrycode=at', $this->openCage->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'KG Innere Stadt',
            'municipality' => 'Austria',
            'province' => 'Vienna',
            'latitude' => 48.2087468,
            'longitude' => 16.370737
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_an_invalid_postal_code()
    {
        $address = $this->openCage->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"documentation":"https://opencagedata.com/api","licenses":[{"name":"see attribution guide","url":"https://opencagedata.com/credits"}],"rate":{"limit":2500,"remaining":2487,"reset":1577059200},"results":[],"status":{"code":200,"message":"OK"},"stay_informed":{"blog":"https://blog.opencagedata.com","twitter":"https://twitter.com/opencagedata"},"thanks":"For using an OpenCage API","timestamp":{"created_http":"Sun, 22 Dec 2019 11:32:21 GMT","created_unix":1577014341},"total_results":0}')
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

        $this->openCage->findByPostcodeAndHouseNumber('1118CP', '202');
    }
}
