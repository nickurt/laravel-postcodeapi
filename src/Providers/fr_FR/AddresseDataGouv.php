<?php

namespace nickurt\postcodeapi\Providers\fr_FR;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\Provider;

class AddresseDataGouv extends Provider
{
    /**
     * @param string $postCode
     * @return Address
     */
    public function find($postCode)
    {
        $this->setRequestUrl(sprintf($this->getRequestUrl(), $postCode, ''));

        $response = $this->request();

        if (count($response['features']) < 1) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setTown($response['features'][0]['properties']['city'])
            ->setLatitude($response['features'][0]['geometry']['coordinates'][1])
            ->setLongitude($response['features'][0]['geometry']['coordinates'][0]);

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
        $this->setRequestUrl(sprintf($this->getRequestUrl(), urlencode($houseNumber), $postCode));

        $response = $this->request();

        if (count($response['features']) < 1) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setHouseNo($response['features'][0]['properties']['housenumber'])
            ->setStreet($response['features'][0]['properties']['street'])
            ->setTown($response['features'][0]['properties']['city'])
            ->setLatitude($response['features'][0]['geometry']['coordinates'][1])
            ->setLongitude($response['features'][0]['geometry']['coordinates'][0]);

        return $address;
    }
}
