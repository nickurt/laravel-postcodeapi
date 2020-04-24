<?php

namespace nickurt\PostcodeApi\tests\Providers\nl_NL;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Exception\NotSupportedException;
use nickurt\PostcodeApi\Providers\nl_NL\PostcodeApiNuV3;
use nickurt\PostcodeApi\tests\Providers\BaseProviderTest;

class PostcodeApiNuV3Test extends BaseProviderTest
{
    const TEST_URL = 'https://sandbox.postcodeapi.nu/v3/lookup/%s/%s';
    const TEST_APIKEY = '00e97e79-63a8-4497-a5de-47ca2cbba64f';

    /** @var PostcodeApiNu */
    protected $postcodeApiNu;

    public function setUp(): void
    {
        $this->postcodeApiNu = (new PostcodeApiNuV3())
            ->setRequestUrl(self::TEST_URL)
            ->setApiKey(self::TEST_APIKEY);
    }

    /** @test */
    public function it_can_get_the_default_config_values_for_this_provider()
    {
        $this->assertSame(self::TEST_URL, $this->postcodeApiNu->getRequestUrl());
        $this->assertSame(self::TEST_APIKEY, $this->postcodeApiNu->getApiKey());
    }

    /** @test */
    public function it_throws_exception_for_find_postal_code()
    {
        $this->expectException(NotSupportedException::class);
        $this->postcodeApiNu->find('6545CA');
    }


    /** @test */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_a_valid_postal_code()
    {
        $address = $this->postcodeApiNu->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"postcode":"6545CA","number":29,"street":"Waldeck Pyrmontsingel","city":"Nijmegen","municipality":"Nijmegen","province":"Gelderland","location":{"type":"Point","coordinates":[5.8696099,51.841554]}}')
            ]),
        ]))->findByPostcodeAndHouseNumber('6545CA', '29');

        $this->assertSame(self::TEST_APIKEY, $this->postcodeApiNu->getApiKey());
        $this->assertSame(sprintf(self::TEST_URL, '6545CA', '29'), $this->postcodeApiNu->getRequestUrl());

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => 'Waldeck Pyrmontsingel',
            'house_no' => '29',
            'town' => 'Nijmegen',
            'municipality' => 'Nijmegen',
            'province' => 'Gelderland',
            'latitude' => 51.841554,
            'longitude' => 5.8696099,
        ], $address->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_an_invalid_postal_code()
    {
        $address = $this->postcodeApiNu->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(404, [], '{"title":"Resource not found"}')
            ]),
        ]))->findByPostcodeAndHouseNumber('6545CA', '299');

        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame([
            'street' => null,
            'house_no' => null,
            'town' => null,
            'municipality' => null,
            'province' => null,
            'latitude' => null,
            'longitude' => null
        ], $address->toArray());
    }
}
