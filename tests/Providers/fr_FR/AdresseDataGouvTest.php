<?php

namespace nickurt\PostcodeApi\tests\Providers\fr_FR;

use nickurt\PostcodeApi\Entity\Address;
use \GuzzleHttp\Psr7\Response;
use \GuzzleHttp\Stream\Stream;

class AdresseDataGouvTest extends \PHPUnit\Framework\TestCase
{
    public function testCanReadFindResponse()
    {
        $json = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'AdresseDataGouv.json');
        $response = new Response(200, [], Stream::factory($json));
        $json = json_decode($response->getBody(), true);

        $this->assertEquals($json['features'][0]['properties']['city'], 'Paris');
        $this->assertEquals($json['features'][0]['geometry']['coordinates'][1], '48.859813');
        $this->assertEquals($json['features'][0]['geometry']['coordinates'][0], '2.31349');
    }

    public function testCanReadFindAddressResponse()
    {
        $json = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'AdresseDataGouv.json');
        $response = new Response(200, [], Stream::factory($json));
        $json = json_decode($response->getBody(), true);

        $address = new Address();
        $address
            ->setTown($json['features'][0]['properties']['city'])
            ->setLatitude($json['features'][0]['geometry']['coordinates'][1])
            ->setLongitude($json['features'][0]['geometry']['coordinates'][0]);

        $this->assertEquals($address->getTown(), 'Paris');
        $this->assertEquals($address->getLatitude(), '48.859813');
        $this->assertEquals($address->getLongitude(), '2.31349');
    }
}
