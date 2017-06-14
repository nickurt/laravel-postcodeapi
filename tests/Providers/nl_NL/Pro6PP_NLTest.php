<?php

namespace nickurt\PostcodeApi\tests\Providers\nl_NL;

use nickurt\PostcodeApi\Entity\Address;
use \GuzzleHttp\Psr7\Response;
use \GuzzleHttp\Stream\Stream;

class Pro6PP_BETest extends \PHPUnit_Framework_TestCase
{
    public function testCanReadFindResponse()
    {
        $json = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'Pro6PP_NL.json');
        $response = new Response(200, [], Stream::factory($json));
        $json = json_decode($response->getBody(), true);

        $this->assertEquals($json['results'][0]['city'], 'Schiphol');
        $this->assertEquals($json['results'][0]['municipality'], 'Haarlemmermeer');
        $this->assertEquals($json['results'][0]['province'], 'Noord-Holland');
        $this->assertEquals($json['results'][0]['lat'], '52.30389');
        $this->assertEquals($json['results'][0]['lng'], '4.7479');
    }

    public function testCanReadFindAddressResponse()
    {
        $json = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'Pro6PP_NL.json');
        $response = new Response(200, [], Stream::factory($json));
        $json = json_decode($response->getBody(), true);

        $address = new Address();
        $address
            ->setTown($json['results'][0]['city'])
            ->setMunicipality($json['results'][0]['municipality'])
            ->setProvince($json['results'][0]['province'])
            ->setLatitude($json['results'][0]['lat'])
            ->setLongitude($json['results'][0]['lng']);

        $this->assertEquals($address->getTown(), 'Schiphol');
        $this->assertEquals($address->getMunicipality(), 'Haarlemmermeer');
        $this->assertEquals($address->getProvince(), 'Noord-Holland');
        $this->assertEquals($address->getLatitude(), '52.30389');
        $this->assertEquals($address->getLongitude(), '4.7479');
    }
}
