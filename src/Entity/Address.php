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

    public function setHouseNo($houseNo)
    {
    	$this->houseNo = $houseNo;
    	return $this;
    }

    public function getHouseNo()
    {
    	return $this->houseNo;
    }

	public function setStreet($street)
	{
		$this->street = $street;
		return $this;
	}

	public function getStreet()
	{
		return $this->street;
	}

	public function setMunicipality($municipality)
	{
		$this->municipality = $municipality;
		return $this;
	}

	public function getMunicipality()
	{
		return $this->municipality;
	}

	public function setTown($town)
	{
		$this->town = $town;
		return $this;
	}

	public function getTown()
	{
		return $this->town;
	}

	public function setProvince($province)
	{
		$this->province = $province;
		return $this;
	}

	public function getProvince()
	{
		return $this->province;
	}

	public function setLatitude($latitude)
	{
		$this->latitude = $latitude;
		return $this;
	}

	public function getLatitude()
	{
		return $this->latitude;
	}

	public function setLongitude($longitude)
	{
		$this->longitude = $longitude;
		return $this;
	}

	public function getLongitude()
	{
		return $this->longitude;
	}
}