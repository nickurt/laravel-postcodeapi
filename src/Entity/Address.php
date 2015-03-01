<?php

namespace nickurt\PostcodeApi\Entity;

class Address
{
    protected $street;
    protected $houseNo;
    protected $town;
    protected $municipality;
    protected $province;
    protected $latitude;
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
}