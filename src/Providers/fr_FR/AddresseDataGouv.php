<?php

namespace nickurt\PostcodeApi\Providers\fr_FR;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\Provider;

class AddresseDataGouv extends Provider
{
    public function find(string $postCode): Address
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

    public function findByPostcode(string $postCode): Address
    {
        return $this->find($postCode);
    }

    public function findByPostcodeAndHouseNumber(string $postCode, string $houseNumber): Address
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
