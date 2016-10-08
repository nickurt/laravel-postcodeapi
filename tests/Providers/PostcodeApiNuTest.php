<?php

namespace nickurt\PostcodeApi\tests\Providers;

use nickurt\PostcodeApi\Entity\Address;
use \GuzzleHttp\Psr7\Response;
use \GuzzleHttp\Stream\Stream;

class PostcodeApiNuTest extends \PHPUnit_Framework_TestCase
{
    public function testCanReadFindResponse()
    {
        $json 		= 	file_get_contents(__DIR__.'\PostcodeApiNu.json');
        $response 	= 	new Response(200, [], Stream::factory($json));
        $json 		= 	json_decode($response->getBody(), true);

        $this->assertEquals($json['resource']['street'], 'Evert van de Beekstraat');
        $this->assertEquals($json['resource']['town'], 'Schiphol');
        $this->assertEquals($json['resource']['municipality'], 'Haarlemmermeer');
        $this->assertEquals($json['resource']['province'], 'Noord-Holland');
        $this->assertEquals($json['resource']['latitude'], '52.3034666667');
        $this->assertEquals($json['resource']['longitude'], '4.7474016667');
    }

    public function testCanReadFindAddressResponse()
    {
        $json 		= 	file_get_contents(__DIR__.'\PostcodeApiNu.json');
        $response 	= 	new Response(200, [], Stream::factory($json));
        $json 		= 	json_decode($response->getBody(), true);

        $address = new Address();
        $address
            ->setStreet($json['resource']['street'])
            ->setTown($json['resource']['town'])
            ->setMunicipality($json['resource']['municipality'])
            ->setProvince($json['resource']['province'])
            ->setLatitude($json['resource']['latitude'])
            ->setLongitude($json['resource']['longitude']);

        $this->assertEquals($address->getStreet(), 'Evert van de Beekstraat');
        $this->assertEquals($address->getTown(), 'Schiphol');
        $this->assertEquals($address->getMunicipality(), 'Haarlemmermeer');
        $this->assertEquals($address->getProvince(), 'Noord-Holland');
        $this->assertEquals($address->getLatitude(), '52.3034666667');
        $this->assertEquals($address->getLongitude(), '4.7474016667');
    }
}