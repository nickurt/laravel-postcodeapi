<?php

namespace nickurt\PostcodeApi\Entity;

use Illuminate\Contracts\Support\Arrayable;

class Address implements Arrayable
{
    /** @var null|string */
    protected $street;

    /** @var null|string */
    protected $houseNo;

    /** @var null|string */
    protected $town;

    /** @var null|string */
    protected $municipality;

    /** @var null|string */
    protected $province;

    /** @var null|float */
    protected $latitude;

    /** @var null|float */
    protected $longitude;

    /**
     * @param string $houseNo
     * @return $this
     */
    public function setHouseNo($houseNo)
    {
        $this->houseNo = $houseNo;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getHouseNo()
    {
        return $this->houseNo;
    }

    /**
     * @param string $street
     * @return $this
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param string $municipality
     * @return $this
     */
    public function setMunicipality($municipality)
    {
        $this->municipality = $municipality;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getMunicipality()
    {
        return $this->municipality;
    }

    /**
     * @param string $town
     * @return $this
     */
    public function setTown($town)
    {
        $this->town = $town;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * @param string $province
     * @return $this
     */
    public function setProvince($province)
    {
        $this->province = $province;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * @param float $latitude
     * @return $this
     */
    public function setLatitude(float $latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param float $longitude
     * @return $this
     */
    public function setLongitude(float $longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return [
            'street' => $this->getStreet(),
            'house_no' => $this->getHouseNo(),
            'town' => $this->getTown(),
            'municipality' => $this->getMunicipality(),
            'province' => $this->getProvince(),
            'latitude' => $this->getLatitude(),
            'longitude' => $this->getLongitude(),
        ];
    }
}
