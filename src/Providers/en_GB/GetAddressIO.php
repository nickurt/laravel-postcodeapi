<?php

namespace nickurt\PostcodeApi\Providers\en_GB;

use Illuminate\Support\Facades\Http;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\Provider;

class GetAddressIO extends Provider
{
    public function find(string $postCode): Address
    {
        $this->setRequestUrl($this->getRequestUrl().'/'.$postCode.'?expand=true');

        $response = $this->request();

        if (isset($response['Message'])) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setLatitude($response['latitude'])
            ->setLongitude($response['longitude'])
            ->setTown($response['addresses'][0]['town_or_city'])
            ->setHouseNo($response['addresses'][0]['building_number'])
            ->setStreet($response['addresses'][0]['thoroughfare']);

        return $address;
    }

    protected function request()
    {
        try {
            return Http::withHeaders(['api-key' => $this->getApiKey()])->get($this->getRequestUrl())->json();
        } catch (\Exception $e) {
            return json_decode($e->getMessage(), true);
        }
    }

    public function findByPostcode(string $postCode): Address
    {
        return $this->find($postCode);
    }

    public function findByPostcodeAndHouseNumber(string $postCode, string $houseNumber): Address
    {
        $this->setRequestUrl($this->getRequestUrl().'/'.$postCode.'/'.$houseNumber.'?expand=true');

        $response = $this->request();

        if (isset($response['Message'])) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setLatitude($response['latitude'])
            ->setLongitude($response['longitude'])
            ->setTown($response['addresses'][0]['town_or_city'])
            ->setHouseNo($response['addresses'][0]['building_number'])
            ->setStreet($response['addresses'][0]['thoroughfare']);

        return $address;
    }
}
