<?php

namespace nickurt\PostcodeApi\Providers\de_DE;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\Provider;

class ZippopotamusDE extends Provider
{
    /**
     * @param string $postCode
     * @return Address
     */
    public function find($postCode)
    {
        $this->setRequestUrl(sprintf($this->getRequestUrl(), $postCode, ''));

        $response = $this->request();

        if (isset($response['places']) < 1) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setTown($response['places'][0]['place name'])
            ->setProvince($response['places'][0]['state'])
            ->setLatitude($response['places'][0]['latitude'])
            ->setLongitude($response['places'][0]['longitude']);

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
     * @return PostCodeApi\Exception
     */
    public function findByPostcodeAndHouseNumber($postCode, $houseNumber)
    {
        throw new \nickurt\PostcodeApi\Exception\NotSupportedException();
    }

}
