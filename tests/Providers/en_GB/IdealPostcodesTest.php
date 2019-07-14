<?php

namespace nickurt\PostcodeApi\tests\Providers\en_GB;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\tests\TestCase;
use PostcodeApi;

class IdealPostcodesTest extends TestCase
{
    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        $postcodeApi = PostcodeApi::create('IdealPostcodes')->setHttpClient(new Client([
            'handler' => new MockHandler([
                new Response(200, [], '{"result":[{"postcode":"SW1A 2AA","postcode_inward":"2AA","postcode_outward":"SW1A","post_town":"LONDON","dependant_locality":"","double_dependant_locality":"","thoroughfare":"Downing Street","dependant_thoroughfare":"","building_number":"10","building_name":"","sub_building_name":"","po_box":"","department_name":"","organisation_name":"Prime Minister & First Lord Of The Treasury","udprn":23747771,"umprn":"","postcode_type":"L","su_organisation_indicator":"","delivery_point_suffix":"1A","line_1":"Prime Minister & First Lord Of The Treasury","line_2":"10 Downing Street","line_3":"","premise":"10","longitude":-0.127695,"latitude":51.50354,"eastings":530047,"northings":179951,"country":"England","traditional_county":"Greater London","administrative_county":"","postal_county":"London","county":"London","district":"Westminster","ward":"St James\'s"}],"code":2000,"message":"Success"}')
            ]),
        ]))->find('SW1A2AA');

        $this->assertInstanceOf(Address::class, $postcodeApi);

        $this->assertSame([
            'street' => 'Prime Minister & First Lord Of The Treasury',
            'house_no' => null,
            'town' => 'LONDON',
            'municipality' => null,
            'province' => null,
            'latitude' => 51.50354,
            'longitude' => -0.127695
        ], $postcodeApi->toArray());
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_an_invalid_postal_code()
    {
        $this->markTestSkipped('Todo');
    }
}
