<?php

namespace nickurt\PostcodeApi\Providers\en_GB;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Exception\NotSupportedException;
use nickurt\PostcodeApi\Providers\Provider;

class GeoPostcodeOrgUk extends Provider
{
    public function find(string $postCode): Address
    {
        $this->setRequestUrl(sprintf($this->getRequestUrl(), $postCode));

        if (!$response = $this->request()) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setLatitude($response['wgs84']['lat'])
            ->setLongitude($response['wgs84']['lon']);

        return $address;
    }

    protected function request()
    {
        try {
            $response = $this->getHttpClient()->request('GET', $this->getRequestUrl());
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return json_decode($e->getResponse()->getBody(), true);
        }

        return json_decode($response->getBody(), true);
    }

    public function findByPostcode(string $postCode): Address
    {
        return $this->find($postCode);
    }

    public function findByPostcodeAndHouseNumber(string $postCode, string $houseNumber): Address
    {
        throw new NotSupportedException();
    }
}
