<?php

namespace nickurt\postcodeapi\Providers\en_GB;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\Provider;

class GetAddressIO extends Provider
{
    /**
     * @param $postCode
     * @return Address
     */
    public function find($postCode)
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
            $response = $this->getHttpClient()->request('GET', $this->getRequestUrl(), [
                'headers' => [
                    'api-key' => $this->getApiKey(),
                ],
            ]);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return json_decode($e->getResponse()->getBody(), true);
        }

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
     * @return Address
     */
    public function findByPostcodeAndHouseNumber($postCode, $houseNumber)
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
