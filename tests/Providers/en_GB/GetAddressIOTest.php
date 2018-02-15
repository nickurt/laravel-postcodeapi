<?php

namespace nickurt\PostcodeApi\tests\Providers\en_GB;

use nickurt\PostcodeApi\Entity\Address;
use \GuzzleHttp\Psr7\Response;
use \GuzzleHttp\Stream\Stream;

class GetAddressIOTest extends \PHPUnit\Framework\TestCase
{
    public function testCanReadFindResponse()
    {
        $json = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'GetAddressIO.json');
        $response = new Response(200, [], Stream::factory($json));
        $json = json_decode($response->getBody(), true);

        $this->assertEquals($json['Latitude'], '51.500571');
        $this->assertEquals($json['Longitude'], '-0.142881');
        $this->assertEquals($json['Addresses'][0], 'Buckingham Palace, , , , , London, Greater London');
    }

    public function testCanReadFindAddressResponse()
    {
        $json = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'GetAddressIO.json');
        $response = new Response(200, [], Stream::factory($json));
        $json = json_decode($response->getBody(), true);

        $address = new Address();
        $address
            ->setLatitude($json['Latitude'])
            ->setLongitude($json['Longitude'])
            ->setStreet($json['Addresses'][0]);

        $this->assertEquals($address->getLatitude(), '51.500571');
        $this->assertEquals($address->getLongitude(), '-0.142881');
        $this->assertEquals($address->getStreet(), 'Buckingham Palace, , , , , London, Greater London');
    }
}
