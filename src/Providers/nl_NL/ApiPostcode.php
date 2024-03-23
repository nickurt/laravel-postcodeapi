<?php

namespace nickurt\PostcodeApi\Providers\nl_NL;

use Illuminate\Support\Facades\Http;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\Provider;

class ApiPostcode extends Provider
{
    public function find(string $postCode): Address
    {
        $postCode = strtoupper(preg_replace('/\s+/', '', $postCode));

        $this->setRequestUrl($this->getRequestUrl().'?postcode='.$postCode);

        $response = $this->request();

        if (isset($response['error'])) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setStreet($response['street'])
            ->setTown($response['city'])
            ->setProvince($response['province'])
            ->setLatitude($response['latitude'])
            ->setLongitude($response['longitude']);

        return $address;
    }

    public function findByPostcode(string $postCode): Address
    {
        return $this->find($postCode);
    }

    public function findByPostcodeAndHouseNumber(string $postCode, string $houseNumber): Address
    {
        $postCode = strtoupper(preg_replace('/\s+/', '', $postCode));

        $this->setRequestUrl($this->getRequestUrl().'?postcode='.$postCode.'&number='.$houseNumber);

        $response = $this->request();

        if (isset($response['error'])) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setHouseNo($response['house_number'])
            ->setStreet($response['street'])
            ->setTown($response['city'])
            ->setProvince($response['province'])
            ->setLatitude($response['latitude'])
            ->setLongitude($response['longitude']);

        return $address;
    }

    protected function request()
    {
        try {
            return Http::withHeaders([
                'Token' => $this->getApiKey(),
            ])->get($this->getRequestUrl())->json();
        } catch (\Exception $e) {
            return json_decode($e->getMessage(), true);
        }
    }
}
