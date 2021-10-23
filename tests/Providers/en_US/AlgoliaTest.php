<?php

namespace nickurt\PostcodeApi\tests\Providers\en_US;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\tests\Providers\BaseProviderTest;

class AlgoliaTest extends BaseProviderTest
{
    /** @var \nickurt\PostcodeApi\Providers\en_US\Algolia */
    protected $algolia;

    public function setUp(): void
    {
        $this->algolia = (new \nickurt\PostcodeApi\Providers\en_US\Algolia())
            ->setRequestUrl('https://places-dsn.algolia.net/1/places/query')
            ->setApiKey('YourAPIKey')
            ->setApiSecret('YourApplicationId');
    }

    /** @test */
    public function it_can_get_the_default_config_values_for_this_provider()
    {
        $this->assertSame('YourAPIKey', $this->algolia->getApiKey());
        $this->assertSame('YourApplicationId', $this->algolia->getApiSecret());
        $this->assertSame('https://places-dsn.algolia.net/1/places/query', $this->algolia->getRequestUrl());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        $address = $this->algolia->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"hits":[{"country":{"de":"Vereinigte Staaten von Amerika","ru":"Соединённые Штаты Америки","pt":"Estados Unidos da América","it":"Stati Uniti d\'America","fr":"États-Unis d\'Amérique","hu":"Amerikai Egyesült Államok","es":"Estados Unidos de América","zh":"美国","ar":"الولايات المتّحدة الأمريكيّة","default":"United States of America","ja":"アメリカ合衆国","pl":"Stany Zjednoczone Ameryki","ro":"Statele Unite ale Americii","nl":"Verenigde Staten van Amerika"},"is_country":false,"is_highway":false,"importance":16,"_tags":["boundary/administrative","city","place/town","country/us","source/geonames"],"postcode":["92270"],"county":{"default":["Riverside County","Riverside"]},"population":17218,"country_code":"us","is_city":true,"is_popular":false,"administrative":["California"],"admin_level":8,"is_suburb":false,"locale_names":{"ar":["رانتشو ميراج"],"default":["Rancho Mirage"],"zh":["兰乔米拉"]},"_geoloc":{"lat":33.7633,"lng":-116.423},"objectID":"5386015","_highlightResult":{"country":{"de":{"value":"Vereinigte Staaten von Amerika","matchLevel":"none","matchedWords":[]},"ru":{"value":"Соединённые Штаты Америки","matchLevel":"none","matchedWords":[]},"pt":{"value":"Estados Unidos da América","matchLevel":"none","matchedWords":[]},"it":{"value":"Stati Uniti d\'America","matchLevel":"none","matchedWords":[]},"fr":{"value":"États-Unis d\'Amérique","matchLevel":"none","matchedWords":[]},"hu":{"value":"Amerikai Egyesült Államok","matchLevel":"none","matchedWords":[]},"es":{"value":"Estados Unidos de América","matchLevel":"none","matchedWords":[]},"zh":{"value":"美国","matchLevel":"none","matchedWords":[]},"ar":{"value":"الولايات المتّحدة الأمريكيّة","matchLevel":"none","matchedWords":[]},"default":{"value":"United States of America","matchLevel":"none","matchedWords":[]},"ja":{"value":"アメリカ合衆国","matchLevel":"none","matchedWords":[]},"pl":{"value":"Stany Zjednoczone Ameryki","matchLevel":"none","matchedWords":[]},"ro":{"value":"Statele Unite ale Americii","matchLevel":"none","matchedWords":[]},"nl":{"value":"Verenigde Staten van Amerika","matchLevel":"none","matchedWords":[]}},"postcode":[{"value":"<em>92270</em>","matchLevel":"full","fullyHighlighted":true,"matchedWords":["92270"]}],"county":{"default":[{"value":"Riverside County","matchLevel":"none","matchedWords":[]},{"value":"Riverside","matchLevel":"none","matchedWords":[]}]},"administrative":[{"value":"California","matchLevel":"none","matchedWords":[]}],"locale_names":{"ar":[{"value":"رانتشو ميراج","matchLevel":"none","matchedWords":[]}],"default":[{"value":"Rancho Mirage","matchLevel":"none","matchedWords":[]}],"zh":[{"value":"兰乔米拉","matchLevel":"none","matchedWords":[]}]}}}],"nbHits":1,"processingTimeMS":3,"query":"92270","params":"query=92270&hitsPerPage=1&countries=us","degradedQuery":false}')
            ]),
        ]))->setOptions(['countries' => 'us'])->find('92270');

        $this->assertSame(["countries" => "us", "query" => "92270", "hitsPerPage" => 1], $this->algolia->getOptions());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Rancho Mirage',
            'municipality' => 'Riverside County',
            'province' => 'California',
            'latitude' => 33.7633,
            'longitude' => -116.423
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code2()
    {
        $address = $this->algolia->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"hits":[{"country":{"de":"Niederlande","ru":"Нидерланды","pt":"Países Baixos","en":"The Netherlands","it":"Paesi Bassi","fr":"Pays-Bas","hu":"Hollandia","es":"Países Bajos","zh":"荷兰","ar":"هولندا","default":"Nederland","ja":"オランダ","pl":"Holandia","ro":"Olanda"},"is_country":false,"city":{"default":["Haarlemmermeer"]},"is_highway":true,"importance":26,"_tags":["highway","highway/motorway","country/nl","address","highway/trunk","source/osm"],"postcode":["2156LC","2132 NA","1171VL","1171PK","1437CL","2156MX","1118DP","1118CP","1118EP","1118EE","1066DJ","2132MA","1435DD","1118ER","1435CJ","1118EN","2132ML","1171NK","1171VK","1118 CP","1171KK","1171KG","2153MA","2371GA","1435EZ","1118EC","1171 VL","2132NA","2132 MA","1118CN","2153KG"],"population":145998,"country_code":"nl","is_city":false,"is_popular":false,"administrative":["Noord-Holland"],"admin_level":15,"suburb":["Nieuw-Vennep","Weteringbrug","Hoofddorp","Badhoevedorp","Schiphol","Rozenburg","Leimuiderbrug","Amsterdam","Rijsenhout","Burgerveen"],"village":["Nieuw-West"],"is_suburb":false,"locale_names":{"default":["A4"]},"_geoloc":{"lat":52.2821,"lng":4.7173},"objectID":"104888737_127572837","_highlightResult":{"country":{"de":{"value":"Niederlande","matchLevel":"none","matchedWords":[]},"ru":{"value":"Нидерланды","matchLevel":"none","matchedWords":[]},"pt":{"value":"Países Baixos","matchLevel":"none","matchedWords":[]},"en":{"value":"The Netherlands","matchLevel":"none","matchedWords":[]},"it":{"value":"Paesi Bassi","matchLevel":"none","matchedWords":[]},"fr":{"value":"Pays-Bas","matchLevel":"none","matchedWords":[]},"hu":{"value":"Hollandia","matchLevel":"none","matchedWords":[]},"es":{"value":"Países Bajos","matchLevel":"none","matchedWords":[]},"zh":{"value":"荷兰","matchLevel":"none","matchedWords":[]},"ar":{"value":"هولندا","matchLevel":"none","matchedWords":[]},"default":{"value":"Nederland","matchLevel":"none","matchedWords":[]},"ja":{"value":"オランダ","matchLevel":"none","matchedWords":[]},"pl":{"value":"Holandia","matchLevel":"none","matchedWords":[]},"ro":{"value":"Olanda","matchLevel":"none","matchedWords":[]}},"city":{"default":[{"value":"Haarlemmermeer","matchLevel":"none","matchedWords":[]}]},"postcode":[{"value":"2156LC","matchLevel":"none","matchedWords":[]},{"value":"2132 NA","matchLevel":"none","matchedWords":[]},{"value":"1171VL","matchLevel":"none","matchedWords":[]},{"value":"1171PK","matchLevel":"none","matchedWords":[]},{"value":"1437CL","matchLevel":"none","matchedWords":[]},{"value":"2156MX","matchLevel":"none","matchedWords":[]},{"value":"1118DP","matchLevel":"none","matchedWords":[]},{"value":"<em>1118CP</em>","matchLevel":"full","fullyHighlighted":true,"matchedWords":["1118cp"]},{"value":"1118EP","matchLevel":"none","matchedWords":[]},{"value":"1118EE","matchLevel":"none","matchedWords":[]},{"value":"1066DJ","matchLevel":"none","matchedWords":[]},{"value":"2132MA","matchLevel":"none","matchedWords":[]},{"value":"1435DD","matchLevel":"none","matchedWords":[]},{"value":"1118ER","matchLevel":"none","matchedWords":[]},{"value":"1435CJ","matchLevel":"none","matchedWords":[]},{"value":"1118EN","matchLevel":"none","matchedWords":[]},{"value":"2132ML","matchLevel":"none","matchedWords":[]},{"value":"1171NK","matchLevel":"none","matchedWords":[]},{"value":"1171VK","matchLevel":"none","matchedWords":[]},{"value":"1118 CP","matchLevel":"none","matchedWords":[]},{"value":"1171KK","matchLevel":"none","matchedWords":[]},{"value":"1171KG","matchLevel":"none","matchedWords":[]},{"value":"2153MA","matchLevel":"none","matchedWords":[]},{"value":"2371GA","matchLevel":"none","matchedWords":[]},{"value":"1435EZ","matchLevel":"none","matchedWords":[]},{"value":"1118EC","matchLevel":"none","matchedWords":[]},{"value":"1171 VL","matchLevel":"none","matchedWords":[]},{"value":"2132NA","matchLevel":"none","matchedWords":[]},{"value":"2132 MA","matchLevel":"none","matchedWords":[]},{"value":"1118CN","matchLevel":"none","matchedWords":[]},{"value":"2153KG","matchLevel":"none","matchedWords":[]}],"administrative":[{"value":"Noord-Holland","matchLevel":"none","matchedWords":[]}],"suburb":[{"value":"Nieuw-Vennep","matchLevel":"none","matchedWords":[]},{"value":"Weteringbrug","matchLevel":"none","matchedWords":[]},{"value":"Hoofddorp","matchLevel":"none","matchedWords":[]},{"value":"Badhoevedorp","matchLevel":"none","matchedWords":[]},{"value":"Schiphol","matchLevel":"none","matchedWords":[]},{"value":"Rozenburg","matchLevel":"none","matchedWords":[]},{"value":"Leimuiderbrug","matchLevel":"none","matchedWords":[]},{"value":"Amsterdam","matchLevel":"none","matchedWords":[]},{"value":"Rijsenhout","matchLevel":"none","matchedWords":[]},{"value":"Burgerveen","matchLevel":"none","matchedWords":[]}],"village":[{"value":"Nieuw-West","matchLevel":"none","matchedWords":[]}],"locale_names":{"default":[{"value":"A4","matchLevel":"none","matchedWords":[]}]}}}],"nbHits":1,"processingTimeMS":3,"query":"1118CP","params":"hitsPerPage=1&countries=nl&query=1118CP","degradedQuery":false}')
            ]),
        ]))->setOptions(['countries' => 'nl'])->find('1118CP');

        $this->assertSame(["countries" => "nl", "query" => "1118CP", "hitsPerPage" => 1], $this->algolia->getOptions());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'A4',
            'municipality' => 'Haarlemmermeer',
            'province' => 'Noord-Holland',
            'latitude' => 52.2821,
            'longitude' => 4.7173
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code3()
    {
        $address = $this->algolia->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"hits":[{"country":{"de":"Vereinigtes Königreich","ru":"Великобритания","pt":"Reino Unido","it":"Regno Unito","fr":"Royaume-Uni","hu":"Egyesült Királyság","zh":"英国","es":"Reino Unido","ar":"المملكة المتحدة","default":"United Kingdom","ja":"イギリス","pl":"Wielka Brytania","ro":"Marea Britanie","nl":"Verenigd Koninkrijk"},"is_country":false,"city":{"default":["City of Westminster"],"ru":["Вестминстер"],"en":["Westminster"]},"is_highway":false,"importance":30,"_tags":["tourism","tourism/attraction","country/gb","address","source/osm"],"postcode":["SW1A 1AA"],"county":{"default":["London"],"ru":["Лондон"],"pt":["Londres"],"fr":["Londres"],"pl":["Londyn"],"es":["Londres"],"nl":["Londen"],"zh":["伦敦"]},"population":233292,"country_code":"gb","is_city":false,"is_popular":false,"administrative":["Greater London"],"admin_level":15,"is_suburb":false,"locale_names":{"default":["Victoria Memorial"],"zh":["维多利亚纪念碑"]},"_geoloc":{"lat":51.5018,"lng":-0.140587},"objectID":"161334744_374945234","_highlightResult":{"country":{"de":{"value":"Vereinigtes Königreich","matchLevel":"none","matchedWords":[]},"ru":{"value":"Великобритания","matchLevel":"none","matchedWords":[]},"pt":{"value":"Reino Unido","matchLevel":"none","matchedWords":[]},"it":{"value":"Regno Unito","matchLevel":"none","matchedWords":[]},"fr":{"value":"Royaume-Uni","matchLevel":"none","matchedWords":[]},"hu":{"value":"Egyesült Királyság","matchLevel":"none","matchedWords":[]},"zh":{"value":"英国","matchLevel":"none","matchedWords":[]},"es":{"value":"Reino Unido","matchLevel":"none","matchedWords":[]},"ar":{"value":"المملكة المتحدة","matchLevel":"none","matchedWords":[]},"default":{"value":"United Kingdom","matchLevel":"none","matchedWords":[]},"ja":{"value":"イギリス","matchLevel":"none","matchedWords":[]},"pl":{"value":"Wielka Brytania","matchLevel":"none","matchedWords":[]},"ro":{"value":"Marea Britanie","matchLevel":"none","matchedWords":[]},"nl":{"value":"Verenigd Koninkrijk","matchLevel":"none","matchedWords":[]}},"city":{"default":[{"value":"City of Westminster","matchLevel":"none","matchedWords":[]}],"ru":[{"value":"Вестминстер","matchLevel":"none","matchedWords":[]}],"en":[{"value":"Westminster","matchLevel":"none","matchedWords":[]}]},"postcode":[{"value":"<em>SW1A 1AA</em>","matchLevel":"full","fullyHighlighted":true,"matchedWords":["sw1a1aa"]}],"county":{"default":[{"value":"London","matchLevel":"none","matchedWords":[]}],"ru":[{"value":"Лондон","matchLevel":"none","matchedWords":[]}],"pt":[{"value":"Londres","matchLevel":"none","matchedWords":[]}],"fr":[{"value":"Londres","matchLevel":"none","matchedWords":[]}],"pl":[{"value":"Londyn","matchLevel":"none","matchedWords":[]}],"es":[{"value":"Londres","matchLevel":"none","matchedWords":[]}],"nl":[{"value":"Londen","matchLevel":"none","matchedWords":[]}],"zh":[{"value":"伦敦","matchLevel":"none","matchedWords":[]}]},"administrative":[{"value":"Greater London","matchLevel":"none","matchedWords":[]}],"locale_names":{"default":[{"value":"Victoria Memorial","matchLevel":"none","matchedWords":[]}],"zh":[{"value":"维多利亚纪念碑","matchLevel":"none","matchedWords":[]}]}}}],"nbHits":1,"processingTimeMS":5,"query":"SW1A1AA","params":"hitsPerPage=1&query=SW1A1AA","degradedQuery":false}')
            ]),
        ]))->find('SW1A1AA');

        $this->assertSame(["query" => "SW1A1AA", "hitsPerPage" => 1], $this->algolia->getOptions());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Victoria Memorial',
            'municipality' => 'London',
            'province' => 'Greater London',
            'latitude' => 51.5018,
            'longitude' => -0.140587
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code4()
    {
        $address = $this->algolia->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"hits":[{"country":{"de":"Australien","ar":"أستراليا","default":"Australia","ru":"Австралия","pt":"Austrália","ja":"オーストラリア","fr":"Australie","hu":"Ausztrália","nl":"Australië","zh":"澳大利亚"},"is_country":false,"city":{"default":["Greater Melbourne"]},"is_highway":true,"importance":26,"_tags":["highway","highway/residential","country/au","address","highway/tertiary","highway/service","source/osm"],"postcode":["3149","3046","3047","3066","3068","3064","VIC 3193"],"county":{"default":["City of Monash","City of Moreland","City of Yarra","City of Hume","City of Bayside"]},"population":0,"country_code":"au","is_city":false,"is_popular":false,"administrative":["Victoria","Greater Melbourne"],"admin_level":15,"suburb":["Mount Waverley","Glenroy","Clifton Hill","Hadfield","Craigieburn","Beaumaris"],"is_suburb":false,"locale_names":{"default":["Hilton Street"]},"_geoloc":{"lat":-37.5953,"lng":144.939},"objectID":"118665275_181595997","_highlightResult":{"country":{"de":{"value":"Australien","matchLevel":"none","matchedWords":[]},"ar":{"value":"أستراليا","matchLevel":"none","matchedWords":[]},"default":{"value":"Australia","matchLevel":"none","matchedWords":[]},"ru":{"value":"Австралия","matchLevel":"none","matchedWords":[]},"pt":{"value":"Austrália","matchLevel":"none","matchedWords":[]},"ja":{"value":"オーストラリア","matchLevel":"none","matchedWords":[]},"fr":{"value":"Australie","matchLevel":"none","matchedWords":[]},"hu":{"value":"Ausztrália","matchLevel":"none","matchedWords":[]},"nl":{"value":"Australië","matchLevel":"none","matchedWords":[]},"zh":{"value":"澳大利亚","matchLevel":"none","matchedWords":[]}},"city":{"default":[{"value":"Greater Melbourne","matchLevel":"none","matchedWords":[]}]},"postcode":[{"value":"3149","matchLevel":"none","matchedWords":[]},{"value":"3046","matchLevel":"none","matchedWords":[]},{"value":"3047","matchLevel":"none","matchedWords":[]},{"value":"<em>3066</em>","matchLevel":"full","fullyHighlighted":true,"matchedWords":["3066"]},{"value":"3068","matchLevel":"none","matchedWords":[]},{"value":"3064","matchLevel":"none","matchedWords":[]},{"value":"VIC 3193","matchLevel":"none","matchedWords":[]}],"county":{"default":[{"value":"City of Monash","matchLevel":"none","matchedWords":[]},{"value":"City of Moreland","matchLevel":"none","matchedWords":[]},{"value":"City of Yarra","matchLevel":"none","matchedWords":[]},{"value":"City of Hume","matchLevel":"none","matchedWords":[]},{"value":"City of Bayside","matchLevel":"none","matchedWords":[]}]},"administrative":[{"value":"Victoria","matchLevel":"none","matchedWords":[]},{"value":"Greater Melbourne","matchLevel":"none","matchedWords":[]}],"suburb":[{"value":"Mount Waverley","matchLevel":"none","matchedWords":[]},{"value":"Glenroy","matchLevel":"none","matchedWords":[]},{"value":"Clifton Hill","matchLevel":"none","matchedWords":[]},{"value":"Hadfield","matchLevel":"none","matchedWords":[]},{"value":"Craigieburn","matchLevel":"none","matchedWords":[]},{"value":"Beaumaris","matchLevel":"none","matchedWords":[]}],"locale_names":{"default":[{"value":"Hilton Street","matchLevel":"none","matchedWords":[]}]}}}],"nbHits":1,"processingTimeMS":6,"query":"3066","params":"hitsPerPage=1&countries=au&query=3066","degradedQuery":false}')
            ]),
        ]))->setOptions(['countries' => 'au'])->find('3066');

        $this->assertSame(["countries" => "au", "query" => "3066", "hitsPerPage" => 1], $this->algolia->getOptions());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Hilton Street',
            'municipality' => 'City of Monash',
            'province' => 'Victoria',
            'latitude' => -37.5953,
            'longitude' => 144.939
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code5()
    {
        $address = $this->algolia->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"hits":[{"country":{"de":"Frankreich","ru":"Франция","pt":"França","it":"Francia","hu":"Franciaország","es":"Francia","zh":"法国","ar":"فرنسا","default":"France","ja":"フランス","pl":"Francja","ro":"Franța","nl":"Frankrijk"},"is_country":false,"city":{"ar":["باريس"],"default":["Paris"],"ru":["Париж"],"ja":["パリ"],"it":["Parigi"],"pl":["Paryż"],"hu":["Párizs"],"es":["París"],"zh":["巴黎"],"nl":["Parijs"]},"is_highway":false,"importance":15,"_tags":["capital","boundary/administrative","city","place/city","country/fr","source/pristine"],"postcode":["75007"],"county":{"default":["Paris"]},"population":2220445,"country_code":"fr","is_city":true,"is_popular":true,"administrative":["Île-de-France"],"admin_level":2,"district":"Paris","is_suburb":true,"locale_names":{"default":["Paris 7e Arrondissement"]},"_geoloc":{"lat":48.8569,"lng":2.32},"objectID":"334690fdd5479294b7b64d243fa73ba4","_highlightResult":{"country":{"de":{"value":"Frankreich","matchLevel":"none","matchedWords":[]},"ru":{"value":"Франция","matchLevel":"none","matchedWords":[]},"pt":{"value":"França","matchLevel":"none","matchedWords":[]},"it":{"value":"Francia","matchLevel":"none","matchedWords":[]},"hu":{"value":"Franciaország","matchLevel":"none","matchedWords":[]},"es":{"value":"Francia","matchLevel":"none","matchedWords":[]},"zh":{"value":"法国","matchLevel":"none","matchedWords":[]},"ar":{"value":"فرنسا","matchLevel":"none","matchedWords":[]},"default":{"value":"France","matchLevel":"none","matchedWords":[]},"ja":{"value":"フランス","matchLevel":"none","matchedWords":[]},"pl":{"value":"Francja","matchLevel":"none","matchedWords":[]},"ro":{"value":"Franța","matchLevel":"none","matchedWords":[]},"nl":{"value":"Frankrijk","matchLevel":"none","matchedWords":[]}},"city":{"ar":[{"value":"باريس","matchLevel":"none","matchedWords":[]}],"default":[{"value":"Paris","matchLevel":"none","matchedWords":[]}],"ru":[{"value":"Париж","matchLevel":"none","matchedWords":[]}],"ja":[{"value":"パリ","matchLevel":"none","matchedWords":[]}],"it":[{"value":"Parigi","matchLevel":"none","matchedWords":[]}],"pl":[{"value":"Paryż","matchLevel":"none","matchedWords":[]}],"hu":[{"value":"Párizs","matchLevel":"none","matchedWords":[]}],"es":[{"value":"París","matchLevel":"none","matchedWords":[]}],"zh":[{"value":"巴黎","matchLevel":"none","matchedWords":[]}],"nl":[{"value":"Parijs","matchLevel":"none","matchedWords":[]}]},"postcode":[{"value":"<em>75007</em>","matchLevel":"full","fullyHighlighted":true,"matchedWords":["75007"]}],"county":{"default":[{"value":"Paris","matchLevel":"none","matchedWords":[]}]},"administrative":[{"value":"Île-de-France","matchLevel":"none","matchedWords":[]}],"locale_names":{"default":[{"value":"Paris 7e Arrondissement","matchLevel":"none","matchedWords":[]}]}}}],"nbHits":1,"processingTimeMS":8,"query":"75007","params":"hitsPerPage=1&countries=fr&query=75007","degradedQuery":false}')
            ]),
        ]))->setOptions(['countries' => 'fr'])->find('75007');

        $this->assertSame(["countries" => "fr", "query" => "75007", "hitsPerPage" => 1], $this->algolia->getOptions());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Paris 7e Arrondissement',
            'municipality' => 'Paris',
            'province' => 'Île-de-France',
            'latitude' => 48.8569,
            'longitude' => 2.32
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code6()
    {
        $address = $this->algolia->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"hits":[{"country":{"de":"Belgien","ru":"Бельгия","pt":"Bélgica","en":"Belgium","it":"Belgio","fr":"Belgique","hu":"Belgium","es":"Bélgica","zh":"比利时","ar":"بلجيكا","default":"België - Belgique - Belgien","ja":"ベルギー","pl":"Belgia","ro":"Belgia","nl":"België"},"is_country":false,"is_highway":false,"importance":15,"_tags":["capital","boundary/administrative","city","country/be","place/city","source/geonames"],"postcode":["1000"],"county":{"ar":["بروكسل العاصمة"],"de":["Brüssel-Hauptstadt"],"default":["Brussel-Hoofdstad - Bruxelles-Capitale","Bruxelles-Capitale"],"ru":["Брюссельский столичный регион"],"en":["Brussels-Capital"],"fr":["Bruxelles-Capitale"],"nl":["Brussel-Hoofdstad"]},"population":153377,"country_code":"be","is_city":true,"is_popular":true,"administrative":["Région de Bruxelles-Capitale - Brussels Hoofdstedelijk Gewest"],"admin_level":2,"is_suburb":false,"locale_names":{"de":["Brüssel","Stadt Brüssel"],"ru":["Брюссель"],"pt":["Bruxelas"],"en":["Brussels","City of Brussels"],"it":["Bruxelles","Città di Bruxelles"],"fr":["Bruxelles","Ville de Bruxelles","Bruxelles-Ville"],"hu":["Brüsszel"],"es":["Bruselas"],"zh":["布魯塞爾"],"ar":["بروكسل"],"default":["Bruxelles - Brussel","BXL","Ville de Bruxelles - Stad Brussel","Brussels"],"ja":["ブリュッセル"],"pl":["Bruksela"],"ro":["Bruxelles"],"nl":["Brussel","Stad Brussel"]},"_geoloc":{"lat":50.8465,"lng":4.3516},"objectID":"2800866","_highlightResult":{"country":{"de":{"value":"Belgien","matchLevel":"none","matchedWords":[]},"ru":{"value":"Бельгия","matchLevel":"none","matchedWords":[]},"pt":{"value":"Bélgica","matchLevel":"none","matchedWords":[]},"en":{"value":"Belgium","matchLevel":"none","matchedWords":[]},"it":{"value":"Belgio","matchLevel":"none","matchedWords":[]},"fr":{"value":"Belgique","matchLevel":"none","matchedWords":[]},"hu":{"value":"Belgium","matchLevel":"none","matchedWords":[]},"es":{"value":"Bélgica","matchLevel":"none","matchedWords":[]},"zh":{"value":"比利时","matchLevel":"none","matchedWords":[]},"ar":{"value":"بلجيكا","matchLevel":"none","matchedWords":[]},"default":{"value":"België - Belgique - Belgien","matchLevel":"none","matchedWords":[]},"ja":{"value":"ベルギー","matchLevel":"none","matchedWords":[]},"pl":{"value":"Belgia","matchLevel":"none","matchedWords":[]},"ro":{"value":"Belgia","matchLevel":"none","matchedWords":[]},"nl":{"value":"België","matchLevel":"none","matchedWords":[]}},"postcode":[{"value":"<em>1000</em>","matchLevel":"full","fullyHighlighted":true,"matchedWords":["1000"]}],"county":{"ar":[{"value":"بروكسل العاصمة","matchLevel":"none","matchedWords":[]}],"de":[{"value":"Brüssel-Hauptstadt","matchLevel":"none","matchedWords":[]}],"default":[{"value":"Brussel-Hoofdstad - Bruxelles-Capitale","matchLevel":"none","matchedWords":[]},{"value":"Bruxelles-Capitale","matchLevel":"none","matchedWords":[]}],"ru":[{"value":"Брюссельский столичный регион","matchLevel":"none","matchedWords":[]}],"en":[{"value":"Brussels-Capital","matchLevel":"none","matchedWords":[]}],"fr":[{"value":"Bruxelles-Capitale","matchLevel":"none","matchedWords":[]}],"nl":[{"value":"Brussel-Hoofdstad","matchLevel":"none","matchedWords":[]}]},"administrative":[{"value":"Région de Bruxelles-Capitale - Brussels Hoofdstedelijk Gewest","matchLevel":"none","matchedWords":[]}],"locale_names":{"de":[{"value":"Brüssel","matchLevel":"none","matchedWords":[]},{"value":"Stadt Brüssel","matchLevel":"none","matchedWords":[]}],"ru":[{"value":"Брюссель","matchLevel":"none","matchedWords":[]}],"pt":[{"value":"Bruxelas","matchLevel":"none","matchedWords":[]}],"en":[{"value":"Brussels","matchLevel":"none","matchedWords":[]},{"value":"City of Brussels","matchLevel":"none","matchedWords":[]}],"it":[{"value":"Bruxelles","matchLevel":"none","matchedWords":[]},{"value":"Città di Bruxelles","matchLevel":"none","matchedWords":[]}],"fr":[{"value":"Bruxelles","matchLevel":"none","matchedWords":[]},{"value":"Ville de Bruxelles","matchLevel":"none","matchedWords":[]},{"value":"Bruxelles-Ville","matchLevel":"none","matchedWords":[]}],"hu":[{"value":"Brüsszel","matchLevel":"none","matchedWords":[]}],"es":[{"value":"Bruselas","matchLevel":"none","matchedWords":[]}],"zh":[{"value":"布魯塞爾","matchLevel":"none","matchedWords":[]}],"ar":[{"value":"بروكسل","matchLevel":"none","matchedWords":[]}],"default":[{"value":"Bruxelles - Brussel","matchLevel":"none","matchedWords":[]},{"value":"BXL","matchLevel":"none","matchedWords":[]},{"value":"Ville de Bruxelles - Stad Brussel","matchLevel":"none","matchedWords":[]},{"value":"Brussels","matchLevel":"none","matchedWords":[]}],"ja":[{"value":"ブリュッセル","matchLevel":"none","matchedWords":[]}],"pl":[{"value":"Bruksela","matchLevel":"none","matchedWords":[]}],"ro":[{"value":"Bruxelles","matchLevel":"none","matchedWords":[]}],"nl":[{"value":"Brussel","matchLevel":"none","matchedWords":[]},{"value":"Stad Brussel","matchLevel":"none","matchedWords":[]}]}}}],"nbHits":1,"processingTimeMS":3,"query":"1000","params":"hitsPerPage=1&countries=be&query=1000","degradedQuery":false}')
            ]),
        ]))->setOptions(['countries' => 'be'])->find('1000');

        $this->assertSame(["countries" => "be", "query" => "1000", "hitsPerPage" => 1], $this->algolia->getOptions());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Bruxelles - Brussel',
            'municipality' => 'Brussel-Hoofdstad - Bruxelles-Capitale',
            'province' => 'Région de Bruxelles-Capitale - Brussels Hoofdstedelijk Gewest',
            'latitude' => 50.8465,
            'longitude' => 4.3516
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code7()
    {
        $address = $this->algolia->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"hits":[{"country":{"ru":"Германия","pt":"Alemanha","en":"Germany","it":"Germania","fr":"Allemagne","hu":"Németország","es":"Alemania","zh":"德国","ar":"ألمانيا","default":"Deutschland","ja":"ドイツ","pl":"Niemcy","ro":"Germania","nl":"Duitsland"},"is_country":false,"is_highway":false,"importance":15,"_tags":["country/de","capital","city","place/city","source/geonames"],"postcode":["10115","10117","10119","10178","10179","10315","10317","10318","10319","10365","10367","10369","10405","10407","10409","10435","10437","10439","10551","10553","10555","10557","10559","10585","10587","10589","10623","10625","10627","10629","10707","10709","10711","10713","10715","10717","10719","10777","10779","10781","10783","10785","10787","10789","10823","10825","10827","10829","10967","11011"],"population":3531201,"country_code":"de","is_city":true,"is_popular":true,"administrative":["Berlin"],"admin_level":2,"is_suburb":false,"locale_names":{"ar":["برلين"],"default":["Berlin"],"ru":["Берлин"],"pt":["Berlim"],"ja":["ベルリン"],"it":["Berlino"],"es":["Berlín"],"zh":["柏林"],"nl":["Berlijn"]},"_geoloc":{"lat":52.517,"lng":13.3888},"objectID":"2950159","_highlightResult":{"country":{"ru":{"value":"Германия","matchLevel":"none","matchedWords":[]},"pt":{"value":"Alemanha","matchLevel":"none","matchedWords":[]},"en":{"value":"Germany","matchLevel":"none","matchedWords":[]},"it":{"value":"Germania","matchLevel":"none","matchedWords":[]},"fr":{"value":"Allemagne","matchLevel":"none","matchedWords":[]},"hu":{"value":"Németország","matchLevel":"none","matchedWords":[]},"es":{"value":"Alemania","matchLevel":"none","matchedWords":[]},"zh":{"value":"德国","matchLevel":"none","matchedWords":[]},"ar":{"value":"ألمانيا","matchLevel":"none","matchedWords":[]},"default":{"value":"Deutschland","matchLevel":"none","matchedWords":[]},"ja":{"value":"ドイツ","matchLevel":"none","matchedWords":[]},"pl":{"value":"Niemcy","matchLevel":"none","matchedWords":[]},"ro":{"value":"Germania","matchLevel":"none","matchedWords":[]},"nl":{"value":"Duitsland","matchLevel":"none","matchedWords":[]}},"postcode":[{"value":"<em>10115</em>","matchLevel":"full","fullyHighlighted":true,"matchedWords":["10115"]},{"value":"10117","matchLevel":"none","matchedWords":[]},{"value":"10119","matchLevel":"none","matchedWords":[]},{"value":"10178","matchLevel":"none","matchedWords":[]},{"value":"10179","matchLevel":"none","matchedWords":[]},{"value":"10315","matchLevel":"none","matchedWords":[]},{"value":"10317","matchLevel":"none","matchedWords":[]},{"value":"10318","matchLevel":"none","matchedWords":[]},{"value":"10319","matchLevel":"none","matchedWords":[]},{"value":"10365","matchLevel":"none","matchedWords":[]},{"value":"10367","matchLevel":"none","matchedWords":[]},{"value":"10369","matchLevel":"none","matchedWords":[]},{"value":"10405","matchLevel":"none","matchedWords":[]},{"value":"10407","matchLevel":"none","matchedWords":[]},{"value":"10409","matchLevel":"none","matchedWords":[]},{"value":"10435","matchLevel":"none","matchedWords":[]},{"value":"10437","matchLevel":"none","matchedWords":[]},{"value":"10439","matchLevel":"none","matchedWords":[]},{"value":"10551","matchLevel":"none","matchedWords":[]},{"value":"10553","matchLevel":"none","matchedWords":[]},{"value":"10555","matchLevel":"none","matchedWords":[]},{"value":"10557","matchLevel":"none","matchedWords":[]},{"value":"10559","matchLevel":"none","matchedWords":[]},{"value":"10585","matchLevel":"none","matchedWords":[]},{"value":"10587","matchLevel":"none","matchedWords":[]},{"value":"10589","matchLevel":"none","matchedWords":[]},{"value":"10623","matchLevel":"none","matchedWords":[]},{"value":"10625","matchLevel":"none","matchedWords":[]},{"value":"10627","matchLevel":"none","matchedWords":[]},{"value":"10629","matchLevel":"none","matchedWords":[]},{"value":"10707","matchLevel":"none","matchedWords":[]},{"value":"10709","matchLevel":"none","matchedWords":[]},{"value":"10711","matchLevel":"none","matchedWords":[]},{"value":"10713","matchLevel":"none","matchedWords":[]},{"value":"10715","matchLevel":"none","matchedWords":[]},{"value":"10717","matchLevel":"none","matchedWords":[]},{"value":"10719","matchLevel":"none","matchedWords":[]},{"value":"10777","matchLevel":"none","matchedWords":[]},{"value":"10779","matchLevel":"none","matchedWords":[]},{"value":"10781","matchLevel":"none","matchedWords":[]},{"value":"10783","matchLevel":"none","matchedWords":[]},{"value":"10785","matchLevel":"none","matchedWords":[]},{"value":"10787","matchLevel":"none","matchedWords":[]},{"value":"10789","matchLevel":"none","matchedWords":[]},{"value":"10823","matchLevel":"none","matchedWords":[]},{"value":"10825","matchLevel":"none","matchedWords":[]},{"value":"10827","matchLevel":"none","matchedWords":[]},{"value":"10829","matchLevel":"none","matchedWords":[]},{"value":"10967","matchLevel":"none","matchedWords":[]},{"value":"11011","matchLevel":"none","matchedWords":[]}],"administrative":[{"value":"Berlin","matchLevel":"none","matchedWords":[]}],"locale_names":{"ar":[{"value":"برلين","matchLevel":"none","matchedWords":[]}],"default":[{"value":"Berlin","matchLevel":"none","matchedWords":[]}],"ru":[{"value":"Берлин","matchLevel":"none","matchedWords":[]}],"pt":[{"value":"Berlim","matchLevel":"none","matchedWords":[]}],"ja":[{"value":"ベルリン","matchLevel":"none","matchedWords":[]}],"it":[{"value":"Berlino","matchLevel":"none","matchedWords":[]}],"es":[{"value":"Berlín","matchLevel":"none","matchedWords":[]}],"zh":[{"value":"柏林","matchLevel":"none","matchedWords":[]}],"nl":[{"value":"Berlijn","matchLevel":"none","matchedWords":[]}]}}}],"nbHits":1,"processingTimeMS":1,"query":"10115","params":"hitsPerPage=1&countries=de&query=10115","degradedQuery":false}')
            ]),
        ]))->setOptions(['countries' => 'de'])->find('10115');

        $this->assertSame(["countries" => "de", "query" => "10115", "hitsPerPage" => 1], $this->algolia->getOptions());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Berlin',
            'municipality' => null,
            'province' => 'Berlin',
            'latitude' => 52.517,
            'longitude' => 13.3888
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code8()
    {
        $address = $this->algolia->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"hits":[{"country":{"ru":"Австрия","pt":"Áustria","en":"Austria","it":"Austria","fr":"Autriche","hu":"Ausztria","es":"Austria","zh":"奥地利","ar":"النمسا","default":"Österreich","ja":"オーストリア","pl":"Austria","ro":"Austria","nl":"Oostenrijk"},"is_country":false,"is_highway":false,"importance":15,"_tags":["capital","city","country/at","place/city","source/geonames"],"postcode":["1010"],"county":{"default":["Wien Stadt"]},"population":1840226,"country_code":"at","is_city":true,"is_popular":true,"administrative":["Wien"],"admin_level":2,"is_suburb":false,"locale_names":{"de":["Wien"],"ru":["Вена"],"pt":["Viena"],"en":["Vienna"],"it":["Vienna"],"fr":["Vienne"],"hu":["Bécs"],"es":["Viena"],"zh":["維也納"],"ar":["فيينا"],"default":["Wien","Vienna"],"ja":["ウィーン"],"pl":["Wiedeń"],"ro":["Viena"],"nl":["Wenen"]},"_geoloc":{"lat":48.2083,"lng":16.3725},"objectID":"2761369","_highlightResult":{"country":{"ru":{"value":"Австрия","matchLevel":"none","matchedWords":[]},"pt":{"value":"Áustria","matchLevel":"none","matchedWords":[]},"en":{"value":"Austria","matchLevel":"none","matchedWords":[]},"it":{"value":"Austria","matchLevel":"none","matchedWords":[]},"fr":{"value":"Autriche","matchLevel":"none","matchedWords":[]},"hu":{"value":"Ausztria","matchLevel":"none","matchedWords":[]},"es":{"value":"Austria","matchLevel":"none","matchedWords":[]},"zh":{"value":"奥地利","matchLevel":"none","matchedWords":[]},"ar":{"value":"النمسا","matchLevel":"none","matchedWords":[]},"default":{"value":"Österreich","matchLevel":"none","matchedWords":[]},"ja":{"value":"オーストリア","matchLevel":"none","matchedWords":[]},"pl":{"value":"Austria","matchLevel":"none","matchedWords":[]},"ro":{"value":"Austria","matchLevel":"none","matchedWords":[]},"nl":{"value":"Oostenrijk","matchLevel":"none","matchedWords":[]}},"postcode":[{"value":"<em>1010</em>","matchLevel":"full","fullyHighlighted":true,"matchedWords":["1010"]}],"county":{"default":[{"value":"Wien Stadt","matchLevel":"none","matchedWords":[]}]},"administrative":[{"value":"Wien","matchLevel":"none","matchedWords":[]}],"locale_names":{"de":[{"value":"Wien","matchLevel":"none","matchedWords":[]}],"ru":[{"value":"Вена","matchLevel":"none","matchedWords":[]}],"pt":[{"value":"Viena","matchLevel":"none","matchedWords":[]}],"en":[{"value":"Vienna","matchLevel":"none","matchedWords":[]}],"it":[{"value":"Vienna","matchLevel":"none","matchedWords":[]}],"fr":[{"value":"Vienne","matchLevel":"none","matchedWords":[]}],"hu":[{"value":"Bécs","matchLevel":"none","matchedWords":[]}],"es":[{"value":"Viena","matchLevel":"none","matchedWords":[]}],"zh":[{"value":"維也納","matchLevel":"none","matchedWords":[]}],"ar":[{"value":"فيينا","matchLevel":"none","matchedWords":[]}],"default":[{"value":"Wien","matchLevel":"none","matchedWords":[]},{"value":"Vienna","matchLevel":"none","matchedWords":[]}],"ja":[{"value":"ウィーン","matchLevel":"none","matchedWords":[]}],"pl":[{"value":"Wiedeń","matchLevel":"none","matchedWords":[]}],"ro":[{"value":"Viena","matchLevel":"none","matchedWords":[]}],"nl":[{"value":"Wenen","matchLevel":"none","matchedWords":[]}]}}}],"nbHits":1,"processingTimeMS":2,"query":"1010","params":"hitsPerPage=1&countries=at&query=1010","degradedQuery":false}')
            ]),
        ]))->setOptions(['countries' => 'at'])->find('1010');

        $this->assertSame(["countries" => "at", "query" => "1010", "hitsPerPage" => 1], $this->algolia->getOptions());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Wien',
            'municipality' => 'Wien Stadt',
            'province' => 'Wien',
            'latitude' => 48.2083,
            'longitude' => 16.3725
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_an_invalid_postal_code()
    {
        $address = $this->algolia->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"hits":[],"nbHits":0,"processingTimeMS":9,"query":"zeroresults","params":"hitsPerPage=1&query=zeroresults","degradedQuery":true}')
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
        $address = $this->algolia->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"hits":[{"country":{"de":"Vereinigte Staaten von Amerika","ru":"Соединённые Штаты Америки","pt":"Estados Unidos da América","it":"Stati Uniti d\'America","fr":"États-Unis d\'Amérique","hu":"Amerikai Egyesült Államok","es":"Estados Unidos de América","zh":"美国","ar":"الولايات المتّحدة الأمريكيّة","default":"United States of America","ja":"アメリカ合衆国","pl":"Stany Zjednoczone Ameryki","ro":"Statele Unite ale Americii","nl":"Verenigde Staten van Amerika"},"is_country":false,"city":{"default":["Skowhegan"]},"is_highway":false,"importance":30,"_tags":["tourism","tourism/attraction","country/us","address","source/osm"],"postcode":["04924"],"county":{"default":["Somerset County"]},"population":8876,"country_code":"us","is_city":false,"is_popular":false,"administrative":["Maine"],"admin_level":15,"is_suburb":false,"locale_names":{"default":["I"]},"_geoloc":{"lat":44.7679,"lng":-69.5845},"objectID":"41968235_3119359809","_highlightResult":{"country":{"de":{"value":"Vereinigte Staaten von Amerika","matchLevel":"none","matchedWords":[]},"ru":{"value":"Соединённые Штаты Америки","matchLevel":"none","matchedWords":[]},"pt":{"value":"Estados Unidos da América","matchLevel":"none","matchedWords":[]},"it":{"value":"Stati Uniti d\'America","matchLevel":"none","matchedWords":[]},"fr":{"value":"États-Unis d\'Amérique","matchLevel":"none","matchedWords":[]},"hu":{"value":"Amerikai Egyesült Államok","matchLevel":"none","matchedWords":[]},"es":{"value":"Estados Unidos de América","matchLevel":"none","matchedWords":[]},"zh":{"value":"美国","matchLevel":"none","matchedWords":[]},"ar":{"value":"الولايات المتّحدة الأمريكيّة","matchLevel":"none","matchedWords":[]},"default":{"value":"United States of America","matchLevel":"none","matchedWords":[]},"ja":{"value":"アメリカ合衆国","matchLevel":"none","matchedWords":[]},"pl":{"value":"Stany Zjednoczone Ameryki","matchLevel":"none","matchedWords":[]},"ro":{"value":"Statele Unite ale Americii","matchLevel":"none","matchedWords":[]},"nl":{"value":"Verenigde Staten van Amerika","matchLevel":"none","matchedWords":[]}},"city":{"default":[{"value":"Skowhegan","matchLevel":"none","matchedWords":[]}]},"postcode":[{"value":"04924","matchLevel":"none","matchedWords":[]}],"county":{"default":[{"value":"Somerset County","matchLevel":"none","matchedWords":[]}]},"administrative":[{"value":"Maine","matchLevel":"none","matchedWords":[]}],"locale_names":{"default":[{"value":"<em>I</em>","matchLevel":"partial","fullyHighlighted":true,"matchedWords":["1"]}]}}}],"nbHits":1,"processingTimeMS":110,"query":"92270 1","params":"query=92270+1&type=address&hitsPerPage=1&countries=us","degradedQuery":false}')
            ]),
        ]))->setOptions(['countries' => 'us'])->findByPostcodeAndHouseNumber('92270', 1);

        $this->assertSame(["countries" => "us", "query" => "92270+1", "hitsPerPage" => 1], $this->algolia->getOptions());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Skowhegan',
            'municipality' => 'Somerset County',
            'province' => 'Maine',
            'latitude' => 44.7679,
            'longitude' => -69.5845
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_a_valid_postal_code2()
    {
        $address = $this->algolia->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"hits":[{"country":{"de":"Niederlande","ru":"Нидерланды","pt":"Países Baixos","en":"The Netherlands","it":"Paesi Bassi","fr":"Pays-Bas","hu":"Hollandia","es":"Países Bajos","zh":"荷兰","ar":"هولندا","default":"Nederland","ja":"オランダ","pl":"Holandia","ro":"Olanda"},"is_country":false,"city":{"default":["Haarlemmermeer"]},"is_highway":true,"importance":26,"_tags":["highway","highway/motorway","country/nl","address","highway/trunk","source/osm"],"postcode":["2156LC","2132 NA","1171VL","1171PK","1437CL","2156MX","1118DP","1118CP","1118EP","1118EE","1066DJ","2132MA","1435DD","1118ER","1435CJ","1118EN","2132ML","1171NK","1171VK","1118 CP","1171KK","1171KG","2153MA","2371GA","1435EZ","1118EC","1171 VL","2132NA","2132 MA","1118CN","2153KG"],"population":145998,"country_code":"nl","is_city":false,"is_popular":false,"administrative":["Noord-Holland"],"admin_level":15,"suburb":["Nieuw-Vennep","Weteringbrug","Hoofddorp","Badhoevedorp","Schiphol","Rozenburg","Leimuiderbrug","Amsterdam","Rijsenhout","Burgerveen"],"village":["Nieuw-West"],"is_suburb":false,"locale_names":{"default":["A4 202"]},"_geoloc":{"lat":52.2821,"lng":4.7173},"objectID":"104888737_127572837","_highlightResult":{"country":{"de":{"value":"Niederlande","matchLevel":"none","matchedWords":[]},"ru":{"value":"Нидерланды","matchLevel":"none","matchedWords":[]},"pt":{"value":"Países Baixos","matchLevel":"none","matchedWords":[]},"en":{"value":"The Netherlands","matchLevel":"none","matchedWords":[]},"it":{"value":"Paesi Bassi","matchLevel":"none","matchedWords":[]},"fr":{"value":"Pays-Bas","matchLevel":"none","matchedWords":[]},"hu":{"value":"Hollandia","matchLevel":"none","matchedWords":[]},"es":{"value":"Países Bajos","matchLevel":"none","matchedWords":[]},"zh":{"value":"荷兰","matchLevel":"none","matchedWords":[]},"ar":{"value":"هولندا","matchLevel":"none","matchedWords":[]},"default":{"value":"Nederland","matchLevel":"none","matchedWords":[]},"ja":{"value":"オランダ","matchLevel":"none","matchedWords":[]},"pl":{"value":"Holandia","matchLevel":"none","matchedWords":[]},"ro":{"value":"Olanda","matchLevel":"none","matchedWords":[]}},"city":{"default":[{"value":"Haarlemmermeer","matchLevel":"none","matchedWords":[]}]},"postcode":[{"value":"2156LC","matchLevel":"none","matchedWords":[]},{"value":"2132 NA","matchLevel":"none","matchedWords":[]},{"value":"1171VL","matchLevel":"none","matchedWords":[]},{"value":"1171PK","matchLevel":"none","matchedWords":[]},{"value":"1437CL","matchLevel":"none","matchedWords":[]},{"value":"2156MX","matchLevel":"none","matchedWords":[]},{"value":"1118DP","matchLevel":"none","matchedWords":[]},{"value":"<em>1118CP</em>","matchLevel":"partial","fullyHighlighted":true,"matchedWords":["1118cp"]},{"value":"1118EP","matchLevel":"none","matchedWords":[]},{"value":"1118EE","matchLevel":"none","matchedWords":[]},{"value":"1066DJ","matchLevel":"none","matchedWords":[]},{"value":"2132MA","matchLevel":"none","matchedWords":[]},{"value":"1435DD","matchLevel":"none","matchedWords":[]},{"value":"1118ER","matchLevel":"none","matchedWords":[]},{"value":"1435CJ","matchLevel":"none","matchedWords":[]},{"value":"1118EN","matchLevel":"none","matchedWords":[]},{"value":"2132ML","matchLevel":"none","matchedWords":[]},{"value":"1171NK","matchLevel":"none","matchedWords":[]},{"value":"1171VK","matchLevel":"none","matchedWords":[]},{"value":"1118 CP","matchLevel":"none","matchedWords":[]},{"value":"1171KK","matchLevel":"none","matchedWords":[]},{"value":"1171KG","matchLevel":"none","matchedWords":[]},{"value":"2153MA","matchLevel":"none","matchedWords":[]},{"value":"2371GA","matchLevel":"none","matchedWords":[]},{"value":"1435EZ","matchLevel":"none","matchedWords":[]},{"value":"1118EC","matchLevel":"none","matchedWords":[]},{"value":"1171 VL","matchLevel":"none","matchedWords":[]},{"value":"2132NA","matchLevel":"none","matchedWords":[]},{"value":"2132 MA","matchLevel":"none","matchedWords":[]},{"value":"1118CN","matchLevel":"none","matchedWords":[]},{"value":"2153KG","matchLevel":"none","matchedWords":[]}],"administrative":[{"value":"Noord-Holland","matchLevel":"none","matchedWords":[]}],"suburb":[{"value":"Nieuw-Vennep","matchLevel":"none","matchedWords":[]},{"value":"Weteringbrug","matchLevel":"none","matchedWords":[]},{"value":"Hoofddorp","matchLevel":"none","matchedWords":[]},{"value":"Badhoevedorp","matchLevel":"none","matchedWords":[]},{"value":"Schiphol","matchLevel":"none","matchedWords":[]},{"value":"Rozenburg","matchLevel":"none","matchedWords":[]},{"value":"Leimuiderbrug","matchLevel":"none","matchedWords":[]},{"value":"Amsterdam","matchLevel":"none","matchedWords":[]},{"value":"Rijsenhout","matchLevel":"none","matchedWords":[]},{"value":"Burgerveen","matchLevel":"none","matchedWords":[]}],"village":[{"value":"Nieuw-West","matchLevel":"none","matchedWords":[]}],"locale_names":{"default":[{"value":"A4 <em>202</em>","matchLevel":"partial","fullyHighlighted":false,"matchedWords":["202"]}]}}}],"nbHits":1,"processingTimeMS":0,"query":"1118CP 202","params":"query=1118CP+202&type=address&hitsPerPage=1&countries=nl","degradedQuery":false}')
            ]),
        ]))->setOptions(['countries' => 'nl'])->findByPostcodeAndHouseNumber('1118CP', 202);

        $this->assertSame(["countries" => "nl", "query" => "1118CP+202", "hitsPerPage" => 1], $this->algolia->getOptions());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Haarlemmermeer',
            'municipality' => 'Haarlemmermeer',
            'province' => 'Noord-Holland',
            'latitude' => 52.2821,
            'longitude' => 4.7173
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_a_valid_postal_code3()
    {
        $address = $this->algolia->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"hits":[{"country":{"de":"Vereinigtes Königreich","ru":"Великобритания","pt":"Reino Unido","it":"Regno Unito","fr":"Royaume-Uni","hu":"Egyesült Királyság","zh":"英国","es":"Reino Unido","ar":"المملكة المتحدة","default":"United Kingdom","ja":"イギリス","pl":"Wielka Brytania","ro":"Marea Britanie","nl":"Verenigd Koninkrijk"},"is_country":false,"city":{"default":["City of Westminster"],"ru":["Вестминстер"],"en":["Westminster"]},"is_highway":false,"importance":30,"_tags":["tourism","tourism/attraction","country/gb","address","source/osm"],"postcode":["SW1A 2AA"],"county":{"default":["London"],"ru":["Лондон"],"pt":["Londres"],"fr":["Londres"],"pl":["Londyn"],"es":["Londres"],"nl":["Londen"],"zh":["伦敦"]},"population":233292,"country_code":"gb","is_city":false,"is_popular":false,"administrative":["Greater London"],"admin_level":15,"is_suburb":false,"locale_names":{"default":["10 Downing Street"],"es":["10 de Downing Street"],"zh":["唐寧街10號"]},"_geoloc":{"lat":51.5035,"lng":-0.127563},"objectID":"200570061_1879842","_highlightResult":{"country":{"de":{"value":"Vereinigtes Königreich","matchLevel":"none","matchedWords":[]},"ru":{"value":"Великобритания","matchLevel":"none","matchedWords":[]},"pt":{"value":"Reino Unido","matchLevel":"none","matchedWords":[]},"it":{"value":"Regno Unito","matchLevel":"none","matchedWords":[]},"fr":{"value":"Royaume-Uni","matchLevel":"none","matchedWords":[]},"hu":{"value":"Egyesült Királyság","matchLevel":"none","matchedWords":[]},"zh":{"value":"英国","matchLevel":"none","matchedWords":[]},"es":{"value":"Reino Unido","matchLevel":"none","matchedWords":[]},"ar":{"value":"المملكة المتحدة","matchLevel":"none","matchedWords":[]},"default":{"value":"United Kingdom","matchLevel":"none","matchedWords":[]},"ja":{"value":"イギリス","matchLevel":"none","matchedWords":[]},"pl":{"value":"Wielka Brytania","matchLevel":"none","matchedWords":[]},"ro":{"value":"Marea Britanie","matchLevel":"none","matchedWords":[]},"nl":{"value":"Verenigd Koninkrijk","matchLevel":"none","matchedWords":[]}},"city":{"default":[{"value":"City of Westminster","matchLevel":"none","matchedWords":[]}],"ru":[{"value":"Вестминстер","matchLevel":"none","matchedWords":[]}],"en":[{"value":"Westminster","matchLevel":"none","matchedWords":[]}]},"postcode":[{"value":"<em>SW1A 2AA</em>","matchLevel":"partial","fullyHighlighted":true,"matchedWords":["sw1a2aa"]}],"county":{"default":[{"value":"London","matchLevel":"none","matchedWords":[]}],"ru":[{"value":"Лондон","matchLevel":"none","matchedWords":[]}],"pt":[{"value":"Londres","matchLevel":"none","matchedWords":[]}],"fr":[{"value":"Londres","matchLevel":"none","matchedWords":[]}],"pl":[{"value":"Londyn","matchLevel":"none","matchedWords":[]}],"es":[{"value":"Londres","matchLevel":"none","matchedWords":[]}],"nl":[{"value":"Londen","matchLevel":"none","matchedWords":[]}],"zh":[{"value":"伦敦","matchLevel":"none","matchedWords":[]}]},"administrative":[{"value":"Greater London","matchLevel":"none","matchedWords":[]}],"locale_names":{"default":[{"value":"<em>10</em> Downing Street","matchLevel":"partial","fullyHighlighted":false,"matchedWords":["10"]}],"es":[{"value":"<em>10</em> de Downing Street","matchLevel":"partial","fullyHighlighted":false,"matchedWords":["10"]}],"zh":[{"value":"唐寧街<em>10</em>號","matchLevel":"partial","fullyHighlighted":false,"matchedWords":["10"]}]}}}],"nbHits":1,"processingTimeMS":5,"query":"SW1A2AA 10","params":"query=SW1A2AA+10&type=address&hitsPerPage=1","degradedQuery":false}')
            ]),
        ]))->findByPostcodeAndHouseNumber('SW1A2AA', 10);

        $this->assertSame(["query" => "SW1A2AA+10", "hitsPerPage" => 1], $this->algolia->getOptions());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'City of Westminster',
            'municipality' => 'London',
            'province' => 'Greater London',
            'latitude' => 51.5035,
            'longitude' => -0.127563
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_a_valid_postal_code4()
    {
        $address = $this->algolia->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"hits":[{"country":{"de":"Australien","ar":"أستراليا","default":"Australia","ru":"Австралия","pt":"Austrália","ja":"オーストラリア","fr":"Australie","hu":"Ausztrália","nl":"Australië","zh":"澳大利亚"},"is_country":false,"city":{"ar":["بيرث"],"default":["Perth"],"ru":["Перт"],"ja":["パース"],"zh":["珀斯"]},"is_highway":true,"importance":27,"_tags":["highway","highway/service","country/au","address","source/osm"],"postcode":["6101"],"population":1907833,"country_code":"au","is_city":false,"is_popular":false,"administrative":["Western Australia"],"admin_level":15,"suburb":["East Victoria Park"],"is_suburb":false,"locale_names":{"default":["3066 Lane 107"]},"_geoloc":{"lat":-31.9822,"lng":115.902},"objectID":"88814855_44953152","_highlightResult":{"country":{"de":{"value":"Australien","matchLevel":"none","matchedWords":[]},"ar":{"value":"أستراليا","matchLevel":"none","matchedWords":[]},"default":{"value":"Australia","matchLevel":"none","matchedWords":[]},"ru":{"value":"Австралия","matchLevel":"none","matchedWords":[]},"pt":{"value":"Austrália","matchLevel":"none","matchedWords":[]},"ja":{"value":"オーストラリア","matchLevel":"none","matchedWords":[]},"fr":{"value":"Australie","matchLevel":"none","matchedWords":[]},"hu":{"value":"Ausztrália","matchLevel":"none","matchedWords":[]},"nl":{"value":"Australië","matchLevel":"none","matchedWords":[]},"zh":{"value":"澳大利亚","matchLevel":"none","matchedWords":[]}},"city":{"ar":[{"value":"بيرث","matchLevel":"none","matchedWords":[]}],"default":[{"value":"Perth","matchLevel":"none","matchedWords":[]}],"ru":[{"value":"Перт","matchLevel":"none","matchedWords":[]}],"ja":[{"value":"パース","matchLevel":"none","matchedWords":[]}],"zh":[{"value":"珀斯","matchLevel":"none","matchedWords":[]}]},"postcode":[{"value":"6101","matchLevel":"none","matchedWords":[]}],"administrative":[{"value":"Western Australia","matchLevel":"none","matchedWords":[]}],"suburb":[{"value":"East Victoria Park","matchLevel":"none","matchedWords":[]}],"locale_names":{"default":[{"value":"<em>3066</em> Lane <em>107</em>","matchLevel":"full","fullyHighlighted":false,"matchedWords":["3066","107"]}]}}}],"nbHits":1,"processingTimeMS":103,"query":"3066 107","params":"query=3066+107&type=address&hitsPerPage=1&countries=au","degradedQuery":false}')
            ]),
        ]))->setOptions(['countries' => 'au'])->findByPostcodeAndHouseNumber('3066', 107);

        $this->assertSame(["countries" => "au", "query" => "3066+107", "hitsPerPage" => 1], $this->algolia->getOptions());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Perth',
            'municipality' => 'Perth',
            'province' => 'Western Australia',
            'latitude' => -31.9822,
            'longitude' => 115.902
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_a_valid_postal_code5()
    {
        $address = $this->algolia->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"hits":[{"country":{"de":"Frankreich","ru":"Франция","pt":"França","it":"Francia","hu":"Franciaország","es":"Francia","zh":"法国","ar":"فرنسا","default":"France","ja":"フランス","pl":"Francja","ro":"Franța","nl":"Frankrijk"},"is_country":false,"city":{"default":["Strasbourg"]},"is_highway":true,"importance":30,"_tags":["address","highway","highway/residential","country/fr","source/pristine"],"postcode":["67000"],"county":{"default":["Bas-Rhin"]},"population":276170,"country_code":"fr","is_city":false,"is_popular":false,"administrative":["Grand-Est"],"admin_level":30,"is_suburb":false,"locale_names":{"default":["2 Rue du Maréchal Foch"]},"_geoloc":{"lat":48.5893,"lng":7.7497},"objectID":"cddb0f033b02942ec2ec92e81696c6d7","_highlightResult":{"country":{"de":{"value":"Frankreich","matchLevel":"none","matchedWords":[]},"ru":{"value":"Франция","matchLevel":"none","matchedWords":[]},"pt":{"value":"França","matchLevel":"none","matchedWords":[]},"it":{"value":"Francia","matchLevel":"none","matchedWords":[]},"hu":{"value":"Franciaország","matchLevel":"none","matchedWords":[]},"es":{"value":"Francia","matchLevel":"none","matchedWords":[]},"zh":{"value":"法国","matchLevel":"none","matchedWords":[]},"ar":{"value":"فرنسا","matchLevel":"none","matchedWords":[]},"default":{"value":"France","matchLevel":"none","matchedWords":[]},"ja":{"value":"フランス","matchLevel":"none","matchedWords":[]},"pl":{"value":"Francja","matchLevel":"none","matchedWords":[]},"ro":{"value":"Franța","matchLevel":"none","matchedWords":[]},"nl":{"value":"Frankrijk","matchLevel":"none","matchedWords":[]}},"city":{"default":[{"value":"Strasbourg","matchLevel":"none","matchedWords":[]}]},"postcode":[{"value":"67000","matchLevel":"none","matchedWords":[]}],"county":{"default":[{"value":"Bas-Rhin","matchLevel":"none","matchedWords":[]}]},"administrative":[{"value":"Grand-Est","matchLevel":"none","matchedWords":[]}],"locale_names":{"default":[{"value":"<em>2</em> Rue du Maréchal Foch","matchLevel":"partial","fullyHighlighted":false,"matchedWords":["2"]}]}}}],"nbHits":1,"processingTimeMS":105,"query":"75007 2","params":"query=75007+2&type=address&hitsPerPage=1&countries=fr","degradedQuery":false}')
            ]),
        ]))->setOptions(['countries' => 'fr'])->findByPostcodeAndHouseNumber('75007', 2);

        $this->assertSame(["countries" => "fr", "query" => "75007+2", "hitsPerPage" => 1], $this->algolia->getOptions());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Strasbourg',
            'municipality' => 'Bas-Rhin',
            'province' => 'Grand-Est',
            'latitude' => 48.5893,
            'longitude' => 7.7497
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_a_valid_postal_code6()
    {
        $address = $this->algolia->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"hits":[{"country":{"de":"Belgien","ru":"Бельгия","pt":"Bélgica","en":"Belgium","it":"Belgio","fr":"Belgique","hu":"Belgium","zh":"比利时","es":"Bélgica","ar":"بلجيكا","default":"België - Belgique - Belgien","ja":"ベルギー","pl":"Belgia","ro":"Belgia","nl":"België"},"is_country":false,"city":{"default":["Mechelen"],"ru":["Мехелен"],"ja":["メヘレン"],"it":["Malines"],"fr":["Malines"],"es":["Malinas"],"zh":["梅赫伦"]},"is_highway":true,"importance":27,"_tags":["highway","highway/service","country/be","address","source/osm"],"postcode":["2812"],"county":{"de":["Mecheln"],"default":["Mechelen"],"ru":["Мехелен"],"fr":["Malines"]},"population":80000,"country_code":"be","is_city":false,"is_popular":false,"administrative":["Vlaanderen"],"admin_level":15,"village":["Muizen"],"is_suburb":false,"locale_names":{"default":["6 1000"]},"_geoloc":{"lat":51.0034,"lng":4.5191},"objectID":"85242980_32468873","_highlightResult":{"country":{"de":{"value":"Belgien","matchLevel":"none","matchedWords":[]},"ru":{"value":"Бельгия","matchLevel":"none","matchedWords":[]},"pt":{"value":"Bélgica","matchLevel":"none","matchedWords":[]},"en":{"value":"Belgium","matchLevel":"none","matchedWords":[]},"it":{"value":"Belgio","matchLevel":"none","matchedWords":[]},"fr":{"value":"Belgique","matchLevel":"none","matchedWords":[]},"hu":{"value":"Belgium","matchLevel":"none","matchedWords":[]},"zh":{"value":"比利时","matchLevel":"none","matchedWords":[]},"es":{"value":"Bélgica","matchLevel":"none","matchedWords":[]},"ar":{"value":"بلجيكا","matchLevel":"none","matchedWords":[]},"default":{"value":"België - Belgique - Belgien","matchLevel":"none","matchedWords":[]},"ja":{"value":"ベルギー","matchLevel":"none","matchedWords":[]},"pl":{"value":"Belgia","matchLevel":"none","matchedWords":[]},"ro":{"value":"Belgia","matchLevel":"none","matchedWords":[]},"nl":{"value":"België","matchLevel":"none","matchedWords":[]}},"city":{"default":[{"value":"Mechelen","matchLevel":"none","matchedWords":[]}],"ru":[{"value":"Мехелен","matchLevel":"none","matchedWords":[]}],"ja":[{"value":"メヘレン","matchLevel":"none","matchedWords":[]}],"it":[{"value":"Malines","matchLevel":"none","matchedWords":[]}],"fr":[{"value":"Malines","matchLevel":"none","matchedWords":[]}],"es":[{"value":"Malinas","matchLevel":"none","matchedWords":[]}],"zh":[{"value":"梅赫伦","matchLevel":"none","matchedWords":[]}]},"postcode":[{"value":"2812","matchLevel":"none","matchedWords":[]}],"county":{"de":[{"value":"Mecheln","matchLevel":"none","matchedWords":[]}],"default":[{"value":"Mechelen","matchLevel":"none","matchedWords":[]}],"ru":[{"value":"Мехелен","matchLevel":"none","matchedWords":[]}],"fr":[{"value":"Malines","matchLevel":"none","matchedWords":[]}]},"administrative":[{"value":"Vlaanderen","matchLevel":"none","matchedWords":[]}],"village":[{"value":"Muizen","matchLevel":"none","matchedWords":[]}],"locale_names":{"default":[{"value":"<em>6</em> <em>1000</em>","matchLevel":"full","fullyHighlighted":true,"matchedWords":["1000","6"]}]}}}],"nbHits":1,"processingTimeMS":103,"query":"1000 6","params":"query=1000+6&type=address&hitsPerPage=1&countries=be","degradedQuery":false}')
            ]),
        ]))->setOptions(['countries' => 'be'])->findByPostcodeAndHouseNumber('1000', 6);

        $this->assertSame(["countries" => "be", "query" => "1000+6", "hitsPerPage" => 1], $this->algolia->getOptions());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Mechelen',
            'municipality' => 'Mechelen',
            'province' => 'Vlaanderen',
            'latitude' => 51.0034,
            'longitude' => 4.5191
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_a_valid_postal_code7()
    {
        $address = $this->algolia->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"hits":[{"country":{"ru":"Германия","pt":"Alemanha","en":"Germany","it":"Germania","fr":"Allemagne","hu":"Németország","es":"Alemania","zh":"德国","ar":"ألمانيا","default":"Deutschland","ja":"ドイツ","pl":"Niemcy","ro":"Germania","nl":"Duitsland"},"is_country":false,"city":{"ar":["برلين"],"default":["Berlin"],"ru":["Берлин"],"pt":["Berlim"],"ja":["ベルリン"],"it":["Berlino"],"es":["Berlín"],"nl":["Berlijn"],"zh":["柏林"]},"is_highway":true,"importance":26,"_tags":["highway","highway/track","country/de","address","highway/residential","highway/tertiary","highway/footway","highway/service","source/osm"],"postcode":["13089","10115","13467","12169","13359","13591","13403","14109","13053","13355","12559"],"population":3531201,"country_code":"de","is_city":false,"is_popular":false,"administrative":["Berlin"],"admin_level":15,"suburb":["Heinersdorf","Mitte","Hermsdorf","Steglitz","Gesundbrunnen","Staaken","Schöneberg","Reinickendorf","Wannsee","Alt-Hohenschönhausen","Müggelheim"],"village":["Pankow","Mitte","Reinickendorf","Steglitz-Zehlendorf","Spandau","Tempelhof-Schöneberg","Lichtenberg","Treptow-Köpenick"],"is_suburb":false,"locale_names":{"default":["Bergstraße 1"]},"_geoloc":{"lat":52.5265,"lng":13.1437},"objectID":"107182423_133482769","_highlightResult":{"country":{"ru":{"value":"Германия","matchLevel":"none","matchedWords":[]},"pt":{"value":"Alemanha","matchLevel":"none","matchedWords":[]},"en":{"value":"Germany","matchLevel":"none","matchedWords":[]},"it":{"value":"Germania","matchLevel":"none","matchedWords":[]},"fr":{"value":"Allemagne","matchLevel":"none","matchedWords":[]},"hu":{"value":"Németország","matchLevel":"none","matchedWords":[]},"es":{"value":"Alemania","matchLevel":"none","matchedWords":[]},"zh":{"value":"德国","matchLevel":"none","matchedWords":[]},"ar":{"value":"ألمانيا","matchLevel":"none","matchedWords":[]},"default":{"value":"Deutschland","matchLevel":"none","matchedWords":[]},"ja":{"value":"ドイツ","matchLevel":"none","matchedWords":[]},"pl":{"value":"Niemcy","matchLevel":"none","matchedWords":[]},"ro":{"value":"Germania","matchLevel":"none","matchedWords":[]},"nl":{"value":"Duitsland","matchLevel":"none","matchedWords":[]}},"city":{"ar":[{"value":"برلين","matchLevel":"none","matchedWords":[]}],"default":[{"value":"Berlin","matchLevel":"none","matchedWords":[]}],"ru":[{"value":"Берлин","matchLevel":"none","matchedWords":[]}],"pt":[{"value":"Berlim","matchLevel":"none","matchedWords":[]}],"ja":[{"value":"ベルリン","matchLevel":"none","matchedWords":[]}],"it":[{"value":"Berlino","matchLevel":"none","matchedWords":[]}],"es":[{"value":"Berlín","matchLevel":"none","matchedWords":[]}],"nl":[{"value":"Berlijn","matchLevel":"none","matchedWords":[]}],"zh":[{"value":"柏林","matchLevel":"none","matchedWords":[]}]},"postcode":[{"value":"13089","matchLevel":"none","matchedWords":[]},{"value":"<em>10115</em>","matchLevel":"partial","fullyHighlighted":true,"matchedWords":["10115"]},{"value":"13467","matchLevel":"none","matchedWords":[]},{"value":"12169","matchLevel":"none","matchedWords":[]},{"value":"13359","matchLevel":"none","matchedWords":[]},{"value":"13591","matchLevel":"none","matchedWords":[]},{"value":"13403","matchLevel":"none","matchedWords":[]},{"value":"14109","matchLevel":"none","matchedWords":[]},{"value":"13053","matchLevel":"none","matchedWords":[]},{"value":"13355","matchLevel":"none","matchedWords":[]},{"value":"12559","matchLevel":"none","matchedWords":[]}],"administrative":[{"value":"Berlin","matchLevel":"none","matchedWords":[]}],"suburb":[{"value":"Heinersdorf","matchLevel":"none","matchedWords":[]},{"value":"Mitte","matchLevel":"none","matchedWords":[]},{"value":"Hermsdorf","matchLevel":"none","matchedWords":[]},{"value":"Steglitz","matchLevel":"none","matchedWords":[]},{"value":"Gesundbrunnen","matchLevel":"none","matchedWords":[]},{"value":"Staaken","matchLevel":"none","matchedWords":[]},{"value":"Schöneberg","matchLevel":"none","matchedWords":[]},{"value":"Reinickendorf","matchLevel":"none","matchedWords":[]},{"value":"Wannsee","matchLevel":"none","matchedWords":[]},{"value":"Alt-Hohenschönhausen","matchLevel":"none","matchedWords":[]},{"value":"Müggelheim","matchLevel":"none","matchedWords":[]}],"village":[{"value":"Pankow","matchLevel":"none","matchedWords":[]},{"value":"Mitte","matchLevel":"none","matchedWords":[]},{"value":"Reinickendorf","matchLevel":"none","matchedWords":[]},{"value":"Steglitz-Zehlendorf","matchLevel":"none","matchedWords":[]},{"value":"Spandau","matchLevel":"none","matchedWords":[]},{"value":"Tempelhof-Schöneberg","matchLevel":"none","matchedWords":[]},{"value":"Lichtenberg","matchLevel":"none","matchedWords":[]},{"value":"Treptow-Köpenick","matchLevel":"none","matchedWords":[]}],"locale_names":{"default":[{"value":"Bergstraße <em>1</em>","matchLevel":"partial","fullyHighlighted":false,"matchedWords":["1"]}]}}}],"nbHits":1,"processingTimeMS":104,"query":"10115 1","params":"query=10115+1&type=address&hitsPerPage=1&countries=de","degradedQuery":false}')
            ]),
        ]))->setOptions(['countries' => 'de'])->findByPostcodeAndHouseNumber('10115', 1);

        $this->assertSame(["countries" => "de", "query" => "10115+1", "hitsPerPage" => 1], $this->algolia->getOptions());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Berlin',
            'municipality' => 'Berlin',
            'province' => 'Berlin',
            'latitude' => 52.5265,
            'longitude' => 13.1437
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_a_valid_postal_code8()
    {
        $address = $this->algolia->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"hits":[{"country":{"ru":"Австрия","pt":"Áustria","en":"Austria","it":"Austria","fr":"Autriche","hu":"Ausztria","es":"Austria","zh":"奥地利","ar":"النمسا","default":"Österreich","ja":"オーストリア","pl":"Austria","ro":"Austria","nl":"Oostenrijk"},"is_country":false,"city":{"default":["Nassereith"]},"is_highway":true,"importance":26,"_tags":["highway","highway/track","country/at","address","source/osm"],"postcode":["6633"],"county":{"default":["Imst"],"ru":["Имст"]},"population":2119,"country_code":"at","is_city":false,"is_popular":false,"administrative":["Tirol"],"admin_level":15,"is_suburb":false,"locale_names":{"default":["25 1010"]},"_geoloc":{"lat":47.3463,"lng":10.8573},"objectID":"118066274_179135337","_highlightResult":{"country":{"ru":{"value":"Австрия","matchLevel":"none","matchedWords":[]},"pt":{"value":"Áustria","matchLevel":"none","matchedWords":[]},"en":{"value":"Austria","matchLevel":"none","matchedWords":[]},"it":{"value":"Austria","matchLevel":"none","matchedWords":[]},"fr":{"value":"Autriche","matchLevel":"none","matchedWords":[]},"hu":{"value":"Ausztria","matchLevel":"none","matchedWords":[]},"es":{"value":"Austria","matchLevel":"none","matchedWords":[]},"zh":{"value":"奥地利","matchLevel":"none","matchedWords":[]},"ar":{"value":"النمسا","matchLevel":"none","matchedWords":[]},"default":{"value":"Österreich","matchLevel":"none","matchedWords":[]},"ja":{"value":"オーストリア","matchLevel":"none","matchedWords":[]},"pl":{"value":"Austria","matchLevel":"none","matchedWords":[]},"ro":{"value":"Austria","matchLevel":"none","matchedWords":[]},"nl":{"value":"Oostenrijk","matchLevel":"none","matchedWords":[]}},"city":{"default":[{"value":"Nassereith","matchLevel":"none","matchedWords":[]}]},"postcode":[{"value":"6633","matchLevel":"none","matchedWords":[]}],"county":{"default":[{"value":"Imst","matchLevel":"none","matchedWords":[]}],"ru":[{"value":"Имст","matchLevel":"none","matchedWords":[]}]},"administrative":[{"value":"Tirol","matchLevel":"none","matchedWords":[]}],"locale_names":{"default":[{"value":"<em>2</em>5 <em>1010</em>","matchLevel":"full","fullyHighlighted":false,"matchedWords":["1010","2"]}]}}}],"nbHits":1,"processingTimeMS":101,"query":"1010 2","params":"query=1010+2&type=address&hitsPerPage=1&countries=at","degradedQuery":false}')
            ]),
        ]))->setOptions(['countries' => 'at'])->findByPostcodeAndHouseNumber('1010', 2);

        $this->assertSame(["countries" => "at", "query" => "1010+2", "hitsPerPage" => 1], $this->algolia->getOptions());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => 'Nassereith',
            'municipality' => 'Imst',
            'province' => 'Tirol',
            'latitude' => 47.3463,
            'longitude' => 10.8573
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_an_invalid_postal_code()
    {
        $address = $this->algolia->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"hits":[],"nbHits":0,"processingTimeMS":9,"query":"zeroresults","params":"hitsPerPage=1&query=zeroresults","degradedQuery":true}')
            ]),
        ]))->findByPostcodeAndHouseNumber('zeroresults', 'zeroresults');

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
}
