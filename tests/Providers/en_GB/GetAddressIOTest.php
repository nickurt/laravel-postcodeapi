<?php

namespace nickurt\PostcodeApi\tests\Providers\en_GB;

use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Facades\Http;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\en_GB\GetAddressIO;
use nickurt\PostcodeApi\tests\TestCase;

class GetAddressIOTest extends TestCase
{
    /** @var GetAddressIO */
    protected $getAddressIO;

    public function setUp(): void
    {
        $this->getAddressIO = (new GetAddressIO)
            ->setRequestUrl('https://api.getaddress.io/find')
            ->setApiKey('qwertyuiopasdfghjkl');
    }

    public function test_it_can_get_the_default_config_values_for_this_provider()
    {
        $this->assertSame('qwertyuiopasdfghjkl', $this->getAddressIO->getApiKey());
        $this->assertSame('https://api.getaddress.io/find', $this->getAddressIO->getRequestUrl());
    }

    public function test_it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        Http::fake(['https://api.getaddress.io/find/SW1A2AA?expand=true' => Http::response('{"postcode":"SW1A 2AA","latitude":51.503038,"longitude":-0.128371,"addresses":[{"formatted_address":["Prime Minister & First Lord of the Treasury","10 Downing Street","","London",""],"thoroughfare":"Downing Street","building_name":"","sub_building_name":"Prime Minister & First Lord of the Treasury","sub_building_number":"","building_number":"10","line_1":"Prime Minister & First Lord of the Treasury","line_2":"10 Downing Street","line_3":"","line_4":"","locality":"","town_or_city":"London","county":"","district":"Westminster","country":"England"}]}')]);

        $address = $this->getAddressIO->find('SW1A2AA');

        $this->assertSame('https://api.getaddress.io/find/SW1A2AA?expand=true', $this->getAddressIO->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => 'Downing Street',
            'house_no' => '10',
            'town' => 'London',
            'municipality' => null,
            'province' => null,
            'latitude' => 51.503038,
            'longitude' => -0.128371,
        ], $address->toArray());
    }

    public function test_it_can_get_the_correct_values_for_find_an_invalid_postal_code()
    {
        Http::fake(['https://api.getaddress.io/find/XX404X?expand=true' => fn () => throw new HttpClientException('{"Message":"Not Found"}', 404)]);

        // GuzzleHttp\Exception\ClientException: Client error: `GET https://api.getaddress.io/find/XX404X?expand=true` resulted in a `404 Not Found` response:
        // {"Message":"Not Found"}

        $address = $this->getAddressIO->find('XX404X');

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
        Http::fake(['https://api.getaddress.io/find/NN13ER/10?expand=true' => Http::response('{"postcode":"NN1 3ER","latitude":52.2458053,"longitude":-0.8924692,"addresses":[{"formatted_address":["10 Watkin Terrace","","","Northampton","Northamptonshire"],"thoroughfare":"Watkin Terrace","building_name":"","sub_building_name":"","sub_building_number":"","building_number":"10","line_1":"10 Watkin Terrace","line_2":"","line_3":"","line_4":"","locality":"","town_or_city":"Northampton","county":"Northamptonshire","district":"Northampton","country":"England"}]}')]);

        $address = $this->getAddressIO->findByPostcodeAndHouseNumber('NN13ER', '10');

        $this->assertSame('https://api.getaddress.io/find/NN13ER/10?expand=true', $this->getAddressIO->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => 'Watkin Terrace',
            'house_no' => '10',
            'town' => 'Northampton',
            'municipality' => null,
            'province' => null,
            'latitude' => 52.2458053,
            'longitude' => -0.8924692,
        ], $address->toArray());
    }

    public function test_it_can_get_the_correct_values_for_find_by_postcode_and_house_number_an_invalid_postal_code()
    {
        Http::fake(['https://api.getaddress.io/find/XX404X/10?expand=true' => fn () => throw new HttpClientException('{"Message":"Not Found"}', 404)]);

        // GuzzleHttp\Exception\ClientException: Client error: `GET https://api.getaddress.io/find/XX404X/10?expand=true` resulted in a `404 Not Found` response:
        // {"Message":"Not Found"}

        $address = $this->getAddressIO->findByPostcodeAndHouseNumber('XX404X', '10');

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
}
