<?php

namespace nickurt\postcodeapi\Providers\nl_NL;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\Provider;

class PostcoDe extends Provider
{
    /**
     * @param $postCode
     * @return Address
     */
    public function find($postCode)
    {
        //
    }

    /**
     * @return mixed
     */
    protected function request()
    {
        $response = $this->getHttpClient()->request('GET', $this->getRequestUrl());

        return json_decode($response->getBody(), true);
    }

    public function findByPostcode($postCode)
    {

    }

    /**
     * @param $postCode
     * @param $houseNumber
     * @return Address
     */
    public function findByPostcodeAndHouseNumber($postCode, $houseNumber)
    {
        $postCode = strtoupper(preg_replace('/\s+/', '', $postCode));

        $this->setRequestUrl(sprintf($this->getRequestUrl(), $postCode, $houseNumber));

        $response = $this->request();

        $address = new Address();
        $address
            ->setHouseNo($houseNumber)
            ->setStreet($response['street'])
            ->setTown($response['city'])
            ->setMunicipality($response['municipality'])
            ->setProvince($response['province'])
            ->setLatitude((float)$response['lat'])
            ->setLongitude((float)$response['lon']);

        return $address;
    }
}
