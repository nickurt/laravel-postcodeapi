<?php

namespace nickurt\PostcodeApi\tests\Entity;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\tests\TestCase;

class AddressTest extends TestCase
{
    /** @var Address */
    protected $address;

    protected function setUp(): void
    {
        $this->address = new Address();
    }

    public function test_it_can_set_and_get_house_number_of_address()
    {
        $this->assertSame('202', $this->address->setHouseNo('202')->getHouseNo());
    }

    public function test_it_can_set_and_get_street_of_address()
    {
        $this->assertSame('Evert van de Beekstraat', $this->address->setStreet('Evert van de Beekstraat')->getStreet());
    }

    public function test_it_can_set_and_get_municipality_of_address()
    {
        $this->assertSame('Haarlemmermeer', $this->address->setMunicipality('Haarlemmermeer')->getMunicipality());
    }

    public function test_it_can_set_and_get_town_of_address()
    {
        $this->assertSame('Schiphol', $this->address->setTown('Schiphol')->getTown());
    }

    public function test_it_can_set_and_get_province_of_address()
    {
        $this->assertSame('Noord-Holland', $this->address->setProvince('Noord-Holland')->getProvince());
    }

    public function test_it_can_set_and_get_latitude_of_address()
    {
        $this->assertSame(52.3038976, $this->address->setLatitude('52.3038976')->getLatitude());
    }

    public function test_it_can_set_and_get_longitude_of_address()
    {
        $this->assertSame(4.7479072, $this->address->setLongitude('4.7479072')->getLongitude());
    }

    public function test_it_can_set_and_get_all_the_values_of_the_address_as_an_array()
    {
        $this->address->setHouseNo('202')
            ->setStreet('Evert van de Beekstraat')
            ->setMunicipality('Haarlemmermeer')
            ->setTown('Schiphol')
            ->setProvince('Noord-Holland')
            ->setLatitude('52.3038976')
            ->setLongitude('4.7479072');

        $this->assertSame([
            'street' => 'Evert van de Beekstraat',
            'house_no' => '202',
            'town' => 'Schiphol',
            'municipality' => 'Haarlemmermeer',
            'province' => 'Noord-Holland',
            'latitude' => 52.3038976,
            'longitude' => 4.7479072,
        ], $this->address->toArray());
    }
}
