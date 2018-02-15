<?php

namespace nickurt\PostcodeApi\tests\Providers\en_GB;

use nickurt\PostcodeApi\Entity\Address;
use \GuzzleHttp\Psr7\Response;
use \GuzzleHttp\Stream\Stream;

class GeoPostcodeOrkUkTest extends \PHPUnit\Framework\TestCase
{
    public function testCanReadFindResponse()
    {
        $json = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'GeoPostcodeOrgUk.json');
        $response = new Response(200, [], Stream::factory($json));
        $json = json_decode($response->getBody(), true);

        $this->assertEquals($json['wgs84']['lat'], '51.501009');
        $this->assertEquals($json['wgs84']['lon'], '-0.141588');
    }

    public function testCanReadFindAddressResponse()
    {
        $json = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'GeoPostcodeOrgUk.json');
        $response = new Response(200, [], Stream::factory($json));
        $json = json_decode($response->getBody(), true);

        $address = new Address();
        $address
            ->setLatitude($json['wgs84']['lat'])
            ->setLongitude($json['wgs84']['lon']);

        $this->assertEquals($address->getLatitude(), '51.501009');
        $this->assertEquals($address->getLongitude(), '-0.141588');
    }
}
