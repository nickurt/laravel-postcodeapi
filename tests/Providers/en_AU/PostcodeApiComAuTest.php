<?php

namespace nickurt\PostcodeApi\tests\Providers\en_AU;

use nickurt\PostcodeApi\Entity\Address;
use \GuzzleHttp\Psr7\Response;
use \GuzzleHttp\Stream\Stream;

class PostcodeApiComAuTest extends \PHPUnit\Framework\TestCase
{
    public function testCanReadFindResponse()
    {
        $json = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'PostcodeApiComAu.json');
        $response = new Response(200, [], Stream::factory($json));
        $json = json_decode($response->getBody(), true);

        $this->assertEquals($json['name'], 'Collingwood');
        $this->assertEquals($json['state']['name'], 'Victoria');
        $this->assertEquals($json['latitude'], '-37.8');
        $this->assertEquals($json['longitude'], '144.9833');
    }

    public function testCanReadFindAddressResponse()
    {
        $json = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'PostcodeApiComAu.json');
        $response = new Response(200, [], Stream::factory($json));
        $json = json_decode($response->getBody(), true);

        $address = new Address();
        $address
            ->setTown($json['name'])
            ->setMunicipality($json['state']['name'])
            ->setLatitude($json['latitude'])
            ->setLongitude($json['longitude']);

        $this->assertEquals($address->getTown(), 'Collingwood');
        $this->assertEquals($address->getMunicipality(), 'Victoria');
        $this->assertEquals($address->getLatitude(), '-37.8');
        $this->assertEquals($address->getLongitude(), '144.9833');
    }
}
