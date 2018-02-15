<?php

namespace nickurt\PostcodeApi\tests\Providers\en_US;

use nickurt\PostcodeApi\Entity\Address;
use \GuzzleHttp\Psr7\Response;
use \GuzzleHttp\Stream\Stream;

class Pro6PP_BETest extends \PHPUnit\Framework\TestCase
{
    public function testCanReadFindResponse()
    {
        $json = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'Pro6PP_BE.json');
        $response = new Response(200, [], Stream::factory($json));
        $json = json_decode($response->getBody(), true);

        $this->assertEquals($json['results'][0]['city'], 'Brussel');
        $this->assertEquals($json['results'][0]['municipality'], 'Brussel');
        $this->assertEquals($json['results'][0]['province'], 'Brussel');
        $this->assertEquals($json['results'][0]['lat'], '50.84515');
        $this->assertEquals($json['results'][0]['lng'], '4.35842');
    }

    public function testCanReadFindAddressResponse()
    {
        $json = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'Pro6PP_BE.json');
        $response = new Response(200, [], Stream::factory($json));
        $json = json_decode($response->getBody(), true);

        $address = new Address();
        $address
            ->setTown($json['results'][0]['city'])
            ->setMunicipality($json['results'][0]['municipality'])
            ->setProvince($json['results'][0]['province'])
            ->setLatitude($json['results'][0]['lat'])
            ->setLongitude($json['results'][0]['lng']);

        $this->assertEquals($address->getTown(), 'Brussel');
        $this->assertEquals($address->getMunicipality(), 'Brussel');
        $this->assertEquals($address->getProvince(), 'Brussel');
        $this->assertEquals($address->getLatitude(), '50.84515');
        $this->assertEquals($address->getLongitude(), '4.35842');
    }
}
