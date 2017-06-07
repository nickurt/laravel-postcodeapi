<?php

namespace nickurt\PostcodeApi\Entity;

class Address
{
    /**
     * @var
     */
    protected $street;

    /**
     * @var
     */
    protected $houseNo;

    /**
     * @var
     */
    protected $town;

    /**
     * @var
     */
    protected $municipality;

    /**
     * @var
     */
    protected $province;

    /**
     * @var
     */
    protected $latitude;

    /**
     * @var
     */
    protected $longitude;

    /**
     * @param $houseNo
     * @return $this
     */
    public function setHouseNo($houseNo)
    {
    	$this->houseNo = $houseNo;
    	return $this;
    }

    /**
     * @return mixed
     */
    public function getHouseNo()
    {
    	return $this->houseNo;
    }

    /**
     * @param $street
     * @return $this
     */
    public function setStreet($street)
    {
        $this->street = $street;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param $municipality
     * @return $this
     */
    public function setMunicipality($municipality)
    {
        $this->municipality = $municipality;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMunicipality()
    {
        return $this->municipality;
    }

    /**
     * @param $town
     * @return $this
     */
    public function setTown($town)
    {
        $this->town = $town;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * @param $province
     * @return $this
     */
    public function setProvince($province)
    {
        $this->province = $province;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * @param $latitude
     * @return $this
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param $longitude
     * @return $this
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @return array
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
            'longitude' => $this->getLongitude()
        ];
    }
}