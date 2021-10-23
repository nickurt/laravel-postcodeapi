<?php

namespace nickurt\PostcodeApi\Providers\en_GB;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\Provider;

class GetAddressIO extends Provider
{
    public function find(string $postCode): Address
    {
        $this->setRequestUrl($this->getRequestUrl() . '/' . $postCode . '?expand=true');

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
            $response = $this->getHttpClient()->request('GET', $this->getRequestUrl(), [
                'headers' => [
                    'api-key' => $this->getApiKey()
                ]
            ]);
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
        $this->setRequestUrl($this->getRequestUrl() . '/' . $postCode . '/' . $houseNumber . '?expand=true');

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
