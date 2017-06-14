<?php

namespace nickurt\PostcodeApi\tests\Providers\en_US;

use nickurt\PostcodeApi\Entity\Address;
use \GuzzleHttp\Psr7\Response;
use \GuzzleHttp\Stream\Stream;

class GeocodioTest extends \PHPUnit_Framework_TestCase
{
    public function testCanReadFindResponse()
    {
        $json = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'Geocodio.json');
        $response = new Response(200, [], Stream::factory($json));
        $json = json_decode($response->getBody(), true);

        $this->assertEquals($json['results'][0]['address_components']['state'], 'CA');
        $this->assertEquals($json['results'][0]['address_components']['formatted_street'], 'Bob Hope Dr');
        $this->assertEquals($json['results'][0]['address_components']['city'], 'Rancho Mirage');
        $this->assertEquals($json['results'][0]['location']['lat'], '33.739464');
        $this->assertEquals($json['results'][0]['location']['lng'], '-116.40803');
    }

    public function testCanReadFindAddressResponse()
    {
        $json = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'Geocodio.json');
        $response = new Response(200, [], Stream::factory($json));
        $json = json_decode($response->getBody(), true);

        $address = new Address();
        $address
            ->setMunicipality($json['results'][0]['address_components']['state'])
            ->setStreet($json['results'][0]['address_components']['formatted_street'])
            ->setTown($json['results'][0]['address_components']['city'])
            ->setLatitude($json['results'][0]['location']['lat'])
            ->setLongitude($json['results'][0]['location']['lng']);

        $this->assertEquals($address->getMunicipality(), 'CA');
        $this->assertEquals($address->getStreet(), 'Bob Hope Dr');
        $this->assertEquals($address->getTown(), 'Rancho Mirage');
        $this->assertEquals($address->getLatitude(), '33.739464');
        $this->assertEquals($address->getLongitude(), '-116.40803');
    }
}
