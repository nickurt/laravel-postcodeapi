<?php

namespace nickurt\PostcodeApi\Entity;

use Illuminate\Contracts\Support\Arrayable;

class Address implements Arrayable
{
    protected ?string $street = null;

    protected ?string $houseNo = null;

    protected ?string $town = null;

    protected ?string $municipality = null;

    protected ?string $province = null;

    protected ?float $latitude = null;

    protected ?float $longitude = null;

    public function setHouseNo(string $houseNo): Address
    {
        $this->houseNo = $houseNo;

        return $this;
    }

    public function getHouseNo(): string|null
    {
        return $this->houseNo;
    }

    public function setStreet(string $street): Address
    {
        $this->street = $street;

        return $this;
    }

    public function getStreet(): string|null
    {
        return $this->street;
    }

    public function setMunicipality(string $municipality): Address
    {
        $this->municipality = $municipality;

        return $this;
    }

    public function getMunicipality(): string|null
    {
        return $this->municipality;
    }

    public function setTown(string $town): Address
    {
        $this->town = $town;

        return $this;
    }

    public function getTown(): string|null
    {
        return $this->town;
    }

    public function setProvince(string $province): Address
    {
        $this->province = $province;

        return $this;
    }

    public function getProvince(): string|null
    {
        return $this->province;
    }

    public function setLatitude(?float $latitude = null): Address
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLatitude(): float|null
    {
        return $this->latitude;
    }

    public function setLongitude(?float $longitude = null): Address
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLongitude(): float|null
    {
        return $this->longitude;
    }

    public function toArray(): array
    {
        return [
            'street' => $this->getStreet(),
            'house_no' => $this->getHouseNo(),
            'town' => $this->getTown(),
            'municipality' => $this->getMunicipality(),
            'province' => $this->getProvince(),
            'latitude' => $this->getLatitude(),
            'longitude' => $this->getLongitude()
        ];
    }
}
