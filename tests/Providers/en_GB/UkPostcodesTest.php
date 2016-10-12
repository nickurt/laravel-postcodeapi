<?php

namespace nickurt\PostcodeApi\tests\Providers\en_GB;

use nickurt\PostcodeApi\Entity\Address;
use \GuzzleHttp\Psr7\Response;
use \GuzzleHttp\Stream\Stream;

class UkPostcodesTest extends \PHPUnit_Framework_TestCase
{
    public function testCanReadFindResponse()
    {
        $json = file_get_contents(__DIR__ . '\UkPostcodes.json');
        $response = new Response(200, [], Stream::factory($json));
        $json = json_decode($response->getBody(), true);

        $this->assertEquals($json['geo']['lat'], '51.501009174414');
        $this->assertEquals($json['geo']['lng'], '-0.14157319687256');
    }

    public function testCanReadFindAddressResponse()
    {
        $json = file_get_contents(__DIR__ . '\UkPostcodes.json');
        $response = new Response(200, [], Stream::factory($json));
        $json = json_decode($response->getBody(), true);

        $address = new Address();
        $address
            ->setLatitude($json['geo']['lat'])
            ->setLongitude($json['geo']['lng']);

        $this->assertEquals($address->getLatitude(), '51.501009174414');
        $this->assertEquals($address->getLongitude(), '-0.14157319687256');
    }
}