<?php

namespace nickurt\PostcodeApi\Providers\en_AU;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Exception\NotSupportedException;
use nickurt\PostcodeApi\Providers\Provider;

class PostcodeApiComAu extends Provider
{
    /**
     * @param string $postCode
     * @return Address
     */
    public function find($postCode)
    {
        $this->setRequestUrl(sprintf($this->getRequestUrl(), $postCode));

        $response = $this->request();

        if (count($response) < 1) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setTown($response[0]['name'])
            ->setMunicipality($response[0]['state']['name'])
            ->setLatitude($response[0]['latitude'])
            ->setLongitude($response[0]['longitude']);

        return $address;
    }

    protected function request()
    {
        $response = $this->getHttpClient()->request('GET', $this->getRequestUrl());

        return json_decode($response->getBody(), true);
    }

    /**
     * @param string $postCode
     * @return mixed
     */
    public function findByPostcode($postCode)
    {
        return $this->find($postCode);
    }

    /**
     * @param string $postCode
     * @param string $houseNumber
     */
    public function findByPostcodeAndHouseNumber($postCode, $houseNumber)
    {
        throw new NotSupportedException();
    }
}
