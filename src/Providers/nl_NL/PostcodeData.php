<?php

namespace nickurt\postcodeapi\Providers\nl_NL;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\Provider;

class PostcodeData extends Provider
{
    /**
     * @param string $postCode
     */
    public function find($postCode)
    {
        throw new \nickurt\PostcodeApi\Exception\NotSupportedException();
    }

    /**
     * @param string $postCode
     */
    public function findByPostcode($postCode)
    {
        throw new \nickurt\PostcodeApi\Exception\NotSupportedException();
    }

    /**
     * @param string $postCode
     * @param string $houseNumber
     * @return Address
     */
    public function findByPostcodeAndHouseNumber($postCode, $houseNumber)
    {
        $this->setRequestUrl(sprintf($this->getRequestUrl(), $postCode, $houseNumber, $_SERVER['HTTP_HOST']));

        $response = $this->request();

        if (isset($response['status']) && $response['status'] == 'error') {
            return new Address();
        }

        $address = new Address();
        $address
            ->setStreet($response['details'][0]['street'])
            ->setHouseNo($houseNumber)
            ->setTown($response['details'][0]['city'])
            ->setMunicipality($response['details'][0]['municipality'])
            ->setProvince($response['details'][0]['province'])
            ->setLatitude($response['details'][0]['lat'])
            ->setLongitude($response['details'][0]['lon']);

        return $address;
    }

    protected function request()
    {
        $response = $this->getHttpClient()->request('GET', $this->getRequestUrl());

        return json_decode($response->getBody(), true);
    }
}
