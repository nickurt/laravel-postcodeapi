<?php

namespace nickurt\PostcodeApi\tests\Providers;

use nickurt\PostcodeApi\Entity\Address;
use \GuzzleHttp\Psr7\Response;
use \GuzzleHttp\Stream\Stream;

class PostcodeDataTest extends \PHPUnit_Framework_TestCase
{
    public function testCanReadFindResponse()
    {
        $json 		= 	file_get_contents(__DIR__.'\PostcodeData.json');
        $response 	= 	new Response(200, [], Stream::factory($json));
        $json 		= 	json_decode($response->getBody(), true);

        $this->assertEquals($json['details'][0]['street'], 'Evert van de Beekstraat');
        $this->assertEquals($json['details'][0]['city'], 'Schiphol');
        $this->assertEquals($json['details'][0]['municipality'], 'Haarlemmermeer');
        $this->assertEquals($json['details'][0]['province'], 'Noord-Holland');
        $this->assertEquals($json['details'][0]['lat'], '52.3035437835548');
        $this->assertEquals($json['details'][0]['lon'], '4.7474064734608');
    }

    public function testCanReadFindAddressResponse()
    {
        $json 		= 	file_get_contents(__DIR__.'\PostcodeData.json');
        $response 	= 	new Response(200, [], Stream::factory($json));
        $json 		= 	json_decode($response->getBody(), true);

        $address = new Address();
        $address
            ->setStreet($json['details'][0]['street'])
            ->setTown($json['details'][0]['city'])
            ->setMunicipality($json['details'][0]['municipality'])
            ->setProvince($json['details'][0]['province'])
            ->setLatitude($json['details'][0]['lat'])
            ->setLongitude($json['details'][0]['lon']);

        $this->assertEquals($address->getStreet(), 'Evert van de Beekstraat');
        $this->assertEquals($address->getTown(), 'Schiphol');
        $this->assertEquals($address->getMunicipality(), 'Haarlemmermeer');
        $this->assertEquals($address->getProvince(), 'Noord-Holland');
        $this->assertEquals($address->getLatitude(), '52.3035437835548');
        $this->assertEquals($address->getLongitude(), '4.7474064734608');
    }
}