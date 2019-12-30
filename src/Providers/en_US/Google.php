<?php

namespace nickurt\postcodeapi\Providers\en_US;

use nickurt\PostcodeApi\Entity\Address;

class Google extends \nickurt\PostcodeApi\Providers\AbstractProvider
{
    /** @var string */
    protected $requestUrl = 'https://maps.googleapis.com/maps/api/geocode/json';

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
        $response = $this->get($this->getRequestUrl() . '?address=' . $postCode . '&key=' . $this->getApiKey());

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

    /**
     * @param string $postCode
     * @param string $houseNumber
     * @return Address
     */
    public function findByPostcodeAndHouseNumber($postCode, $houseNumber)
    {
        $response = $this->get($this->getRequestUrl() . '?address=' . $postCode . '+' . $houseNumber . '&key=' . $this->getApiKey());

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
