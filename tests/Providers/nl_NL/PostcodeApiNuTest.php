<?php

namespace nickurt\PostcodeApi\tests\Providers\nl_NL;

use nickurt\PostcodeApi\Entity\Address;
use \GuzzleHttp\Psr7\Response;
use \GuzzleHttp\Stream\Stream;

class PostcodeApiNuTest extends \PHPUnit_Framework_TestCase
{
    public function testCanReadFindResponse()
    {
        $json = file_get_contents(__DIR__.'\PostcodeApiNu.json');
        $response = new Response(200, [], Stream::factory($json));
        $json = json_decode($response->getBody(), true);

        $this->assertEquals($json['_embedded']['addresses'][0]['street'], 'Evert van de Beekstraat');
        $this->assertEquals($json['_embedded']['addresses'][0]['city']['label'], 'Schiphol');
        $this->assertEquals($json['_embedded']['addresses'][0]['municipality']['label'], 'Haarlemmermeer');
        $this->assertEquals($json['_embedded']['addresses'][0]['province']['label'], 'Noord-Holland');
        $this->assertEquals($json['_embedded']['addresses'][0]['geo']['center']['wgs84']['coordinates'][1], '52.3052531');
        $this->assertEquals($json['_embedded']['addresses'][0]['geo']['center']['wgs84']['coordinates'][0], '4.7517051');
    }

    public function testCanReadFindAddressResponse()
    {
        $json = file_get_contents(__DIR__.'\PostcodeApiNu.json');
        $response = new Response(200, [], Stream::factory($json));
        $json = json_decode($response->getBody(), true);

        $address = new Address();
        $address
            ->setStreet($json['_embedded']['addresses'][0]['street'])
            ->setTown($json['_embedded']['addresses'][0]['city']['label'])
            ->setMunicipality($json['_embedded']['addresses'][0]['municipality']['label'])
            ->setProvince($json['_embedded']['addresses'][0]['province']['label'])
            ->setLatitude($json['_embedded']['addresses'][0]['geo']['center']['wgs84']['coordinates'][1])
            ->setLongitude($json['_embedded']['addresses'][0]['geo']['center']['wgs84']['coordinates'][0]);

        $this->assertEquals($address->getStreet(), 'Evert van de Beekstraat');
        $this->assertEquals($address->getTown(), 'Schiphol');
        $this->assertEquals($address->getMunicipality(), 'Haarlemmermeer');
        $this->assertEquals($address->getProvince(), 'Noord-Holland');
        $this->assertEquals($address->getLatitude(), '52.3052531');
        $this->assertEquals($address->getLongitude(), '4.7517051');
    }
}