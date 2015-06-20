<?php

namespace nickurt\PostcodeApi\tests\Providers;

use nickurt\PostcodeApi\Entity\Address;
use \GuzzleHttp\Message\Response;
use \GuzzleHttp\Stream\Stream;

class GetAddressIOTest extends \PHPUnit_Framework_TestCase
{
    public function testCanReadFindResponse()
    {
        $json 		= 	file_get_contents(__DIR__.'\GetAddressIO.json');
        $response 	= 	new Response(200, [], Stream::factory($json));
        $json 		= 	$response->json();

        $this->assertEquals($json['Latitude'], '51.503038');
        $this->assertEquals($json['Longitude'], '-0.128371');
        $this->assertEquals($json['Addresses'][0], 'Prime Minister & First Lord of the Treasury, 10 Downing Street, , , , London, Greater London');
    }

    public function testCanReadFindAddressResponse()
    {
        $json 		= 	file_get_contents(__DIR__.'\GetAddressIO.json');
        $response 	= 	new Response(200, [], Stream::factory($json));
        $json 		= 	$response->json();

        $address = new Address();
        $address
            ->setLatitude($json['Latitude'])
            ->setLongitude($json['Longitude'])
            ->setStreet($json['Addresses'][0]);

        $this->assertEquals($address->getLatitude(), '51.503038');
        $this->assertEquals($address->getLongitude(), '-0.128371');
        $this->assertEquals($address->getStreet(), 'Prime Minister & First Lord of the Treasury, 10 Downing Street, , , , London, Greater London');
    }
}