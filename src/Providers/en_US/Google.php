<?php

namespace nickurt\PostcodeApi\Providers\en_US;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\Provider;

class Google extends Provider
{
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
     * @return Address
     */
    public function find($postCode)
    {
        $this->setRequestUrl($this->getRequestUrl() . '?address=' . $postCode . '&key=' . $this->getApiKey());

        $response = $this->request();

        if (count($response['results']) < 1) {
            return new Address();
        }

        $components = collect($response['results'][0]['address_components'])->mapWithKeys(function ($item, $value) {
            return [$item['types'][0] => $item];
        })->toArray();

        $address = new Address();
        $address
            ->setStreet($components['route']['long_name'] ?? null)
            ->setHouseNo($components['street_number']['long_name'] ?? null)
            ->setTown($components['locality']['long_name'] ?? $components['postal_town']['long_name'])
            ->setMunicipality($components['administrative_area_level_2']['long_name'] ?? null)
            ->setProvince($components['administrative_area_level_1']['long_name'] ?? null)
            ->setLatitude($response['results'][0]['geometry']['location']['lat'])
            ->setLongitude($response['results'][0]['geometry']['location']['lng']);

        return $address;
    }

    protected function request()
    {
        $response = $this->getHttpClient()->request('GET', $this->getRequestUrl());

        return json_decode($response->getBody(), true);
    }

    /**
     * @param string $postCode
     * @param string $houseNumber
     * @return Address
     */
    public function findByPostcodeAndHouseNumber($postCode, $houseNumber)
    {
        $this->setRequestUrl($this->getRequestUrl() . '?address=' . $postCode . '+' . $houseNumber . '&key=' . $this->getApiKey());

        $response = $this->request();

        if (count($response['results']) < 1) {
            return new Address();
        }

        $components = collect($response['results'][0]['address_components'])->mapWithKeys(function ($item, $value) {
            return [$item['types'][0] => $item];
        })->toArray();

        $address = new Address();
        $address
            ->setStreet($components['route']['long_name'] ?? null)
            ->setHouseNo($components['street_number']['long_name'] ?? null)
            ->setTown($components['locality']['long_name'] ?? $components['postal_town']['long_name'])
            ->setMunicipality($components['administrative_area_level_2']['long_name'] ?? null)
            ->setProvince($components['administrative_area_level_1']['long_name'] ?? null)
            ->setLatitude($response['results'][0]['geometry']['location']['lat'])
            ->setLongitude($response['results'][0]['geometry']['location']['lng']);

        return $address;
    }
}
