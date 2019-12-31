<?php

namespace nickurt\PostcodeApi\tests\Providers\en_GB;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\en_GB\GetAddressIO;
use nickurt\PostcodeApi\tests\Providers\BaseProviderTest;

class GetAddressIOTest extends BaseProviderTest
{
    /** @var GetAddressIO */
    protected $getAddressIO;

    public function setUp(): void
    {
        $this->getAddressIO = (new GetAddressIO)
            ->setApiKey('qwertyuiopasdfghjkl');
    }

    /** @test */
    public function it_can_get_the_default_config_values_for_this_provider()
    {
        $this->assertSame('qwertyuiopasdfghjkl', $this->getAddressIO->getApiKey());
        $this->assertSame('https://api.getaddress.io/find', $this->getAddressIO->getRequestUrl());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        $address = $this->getAddressIO->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"postcode":"SW1A 2AA","latitude":51.503038,"longitude":-0.128371,"addresses":[{"formatted_address":["Prime Minister & First Lord of the Treasury","10 Downing Street","","London",""],"thoroughfare":"Downing Street","building_name":"","sub_building_name":"Prime Minister & First Lord of the Treasury","sub_building_number":"","building_number":"10","line_1":"Prime Minister & First Lord of the Treasury","line_2":"10 Downing Street","line_3":"","line_4":"","locality":"","town_or_city":"London","county":"","district":"Westminster","country":"England"}]}')
            ]),
        ]))->find('SW1A2AA');

        $this->assertSame('https://api.getaddress.io/find/SW1A2AA?expand=true', (string)$this->getAddressIO->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => 'Downing Street',
            'house_no' => '10',
            'town' => 'London',
            'municipality' => null,
            'province' => null,
            'latitude' => 51.503038,
            'longitude' => -0.128371
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_an_invalid_postal_code()
    {
        // GuzzleHttp\Exception\ClientException: Client error: `GET https://api.getaddress.io/find/XX404X?expand=true` resulted in a `404 Not Found` response:
        // {"Message":"Not Found"}

        $address = $this->getAddressIO->setHttpClient(new Client([
            'handler' => MockHandler::createWithMiddleware([
                new Response(404, [], '{"Message":"Not Found"}')
            ])
        ]))->find('XX404X');

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
        $address = $this->getAddressIO->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"postcode":"NN1 3ER","latitude":52.2458053,"longitude":-0.8924692,"addresses":[{"formatted_address":["10 Watkin Terrace","","","Northampton","Northamptonshire"],"thoroughfare":"Watkin Terrace","building_name":"","sub_building_name":"","sub_building_number":"","building_number":"10","line_1":"10 Watkin Terrace","line_2":"","line_3":"","line_4":"","locality":"","town_or_city":"Northampton","county":"Northamptonshire","district":"Northampton","country":"England"}]}')
            ]),
        ]))->findByPostcodeAndHouseNumber('NN13ER', '10');

        $this->assertSame('https://api.getaddress.io/find/NN13ER/10?expand=true', (string)$this->getAddressIO->getHttpClient()->getConfig('handler')->getLastRequest()->getUri());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => 'Watkin Terrace',
            'house_no' => '10',
            'town' => 'Northampton',
            'municipality' => null,
            'province' => null,
            'latitude' => 52.2458053,
            'longitude' => -0.8924692
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_an_invalid_postal_code()
    {
        // GuzzleHttp\Exception\ClientException: Client error: `GET https://api.getaddress.io/find/XX404X/10?expand=true` resulted in a `404 Not Found` response:
        // {"Message":"Not Found"}

        $address = $this->getAddressIO->setHttpClient(new Client([
            'handler' => MockHandler::createWithMiddleware([
                new Response(404, [], '{"Message":"Not Found"}')
            ]),
        ]))->findByPostcodeAndHouseNumber('XX404X', '10');

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
