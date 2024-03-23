<?php

namespace nickurt\PostcodeApi\Providers\en_US;

use Illuminate\Support\Facades\Http;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\Provider;

class Google extends Provider
{
    public function findByPostcode(string $postCode): Address
    {
        return $this->find($postCode);
    }

    public function find(string $postCode): Address
    {
        $this->setRequestUrl($this->getRequestUrl().'?address='.$postCode.'&key='.$this->getApiKey());

        $response = $this->request();

        if (count($response['results']) < 1) {
            return new Address();
        }

        $components = collect($response['results'][0]['address_components'])->mapWithKeys(function ($item, $value) {
            return [$item['types'][0] => $item];
        })->toArray();

        $address = new Address();
        $address
            ->setTown($components['locality']['long_name'] ?? $components['postal_town']['long_name'])
            ->setLatitude($response['results'][0]['geometry']['location']['lat'])
            ->setLongitude($response['results'][0]['geometry']['location']['lng']);

        if ($street = $components['route']['long_name'] ?? null) {
            $address->setStreet($street);
        }

        if ($houseNo = $components['street_number']['long_name'] ?? null) {
            $address->setHouseNo($houseNo);
        }

        if ($municipality = $components['administrative_area_level_2']['long_name'] ?? null) {
            $address->setMunicipality($municipality);
        }

        if ($province = $components['administrative_area_level_1']['long_name'] ?? null) {
            $address->setProvince($province);
        }

        return $address;
    }

    protected function request()
    {
        return Http::get($this->getRequestUrl())->json();
    }

    public function findByPostcodeAndHouseNumber(string $postCode, string $houseNumber): Address
    {
        $this->setRequestUrl($this->getRequestUrl().'?address='.$postCode.'+'.$houseNumber.'&key='.$this->getApiKey());

        $response = $this->request();

        if (count($response['results']) < 1) {
            return new Address();
        }

        $components = collect($response['results'][0]['address_components'])->mapWithKeys(function ($item, $value) {
            return [$item['types'][0] => $item];
        })->toArray();

        $address = new Address();
        $address
            ->setTown($components['locality']['long_name'] ?? $components['postal_town']['long_name'])
            ->setLatitude($response['results'][0]['geometry']['location']['lat'])
            ->setLongitude($response['results'][0]['geometry']['location']['lng']);

        if ($street = $components['route']['long_name'] ?? null) {
            $address->setStreet($street);
        }

        if ($houseNo = $components['street_number']['long_name'] ?? null) {
            $address->setHouseNo($houseNo);
        }

        if ($municipality = $components['administrative_area_level_2']['long_name'] ?? null) {
            $address->setMunicipality($municipality);
        }

        if ($province = $components['administrative_area_level_1']['long_name'] ?? null) {
            $address->setProvince($province);
        }

        return $address;
    }
}
