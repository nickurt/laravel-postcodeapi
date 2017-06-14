<?php

namespace nickurt\PostcodeApi\tests\Providers\en_GB;

use nickurt\PostcodeApi\Entity\Address;
use \GuzzleHttp\Psr7\Response;
use \GuzzleHttp\Stream\Stream;

class IdealPostcodesTest extends \PHPUnit_Framework_TestCase
{
    public function testCanReadFindResponse()
    {
        $json = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'IdealPostcodes.json');
        $response = new Response(200, [], Stream::factory($json));
        $json = json_decode($response->getBody(), true);

        $this->assertEquals($json['result'][0]['post_town'], 'LONDON');
        $this->assertEquals($json['result'][0]['line_1'], 'Buckingham Palace');
        $this->assertEquals($json['result'][0]['latitude'], '51.50100915646');
        $this->assertEquals($json['result'][0]['longitude'], '-0.14158759787698');
    }

    public function testCanReadFindAddressResponse()
    {
        $json = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'IdealPostcodes.json');
        $response = new Response(200, [], Stream::factory($json));
        $json = json_decode($response->getBody(), true);

        $address = new Address();
        $address
            ->setTown($json['result'][0]['post_town'])
            ->setStreet($json['result'][0]['line_1'])
            ->setLatitude($json['result'][0]['latitude'])
            ->setLongitude($json['result'][0]['longitude']);

        $this->assertEquals($address->getTown(), 'LONDON');
        $this->assertEquals($address->getStreet(), 'Buckingham Palace');
        $this->assertEquals($address->getLatitude(), '51.50100915646');
        $this->assertEquals($address->getLongitude(), '-0.14158759787698');
    }
}
