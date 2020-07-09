<?php

namespace nickurt\PostcodeApi\Providers\de_DE;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\Provider;

class GeonamesDE extends Provider
{
    /**
     * @param string $postCode
     * @return Address
     */
    public function find($postCode)
    {
        $this->setRequestUrl(sprintf($this->getRequestUrl(), $postCode, ''));

        $response = $this->request();

        if (count($response['postalcodes']) < 1) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setTown($response['postalcodes'][0]['placeName'])
            ->setMunicipality($response['postalcodes'][0]['adminName3'])
            ->setProvince($response['postalcodes'][0]['adminName1'])
            ->setLatitude($response['postalcodes'][0]['lat'])
            ->setLongitude($response['postalcodes'][0]['lng']);

        return $address;
    }

    protected function request()
    {
        $response = $this->getHttpClient()->request('GET', $this->getRequestUrl());

        return json_decode($response->getBody(), true);
    }

    /**
     * @param string $postCode
     * @return Address
     */
    public function findByPostcode($postCode)
    {
        return $this->find($postCode);
    }

    /**
     * @param string $postCode
     * @param string $houseNumber
     * @return Address
     */
    public function findByPostcodeAndHouseNumber($postCode, $houseNumber)
    {
        $this->setRequestUrl( sprintf( $this->getRequestUrl(), $postCode . '&placename=' . $houseNumber, '') );

        $response = $this->request();

        if (count($response['postalcodes']) < 1) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setTown($response['postalcodes'][0]['placeName'])
            ->setMunicipality($response['postalcodes'][0]['adminName3'])
            ->setProvince($response['postalcodes'][0]['adminName1'])
            ->setLatitude($response['postalcodes'][0]['lat'])
            ->setLongitude($response['postalcodes'][0]['lng']);

        return $address;
    }

}
