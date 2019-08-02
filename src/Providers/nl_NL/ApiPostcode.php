<?php

namespace nickurt\postcodeapi\Providers\nl_NL;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\Provider;

class ApiPostcode extends Provider
{
    /**
     * @param $postCode
     * @return Address
     */
    public function find($postCode)
    {

    }

    public function findByPostcode($postCode)
    {

    }

    /**
     * @param $postCode
     * @param $houseNumber
     * @return Address
     */
    public function findByPostcodeAndHouseNumber($postCode, $houseNumber)
    {
        $postCode = strtoupper(preg_replace('/\s+/', '', $postCode));

        $this->setRequestUrl(sprintf($this->getRequestUrl(), $postCode, $houseNumber));

        $response = $this->request();

        $address = new Address();
        $address
            ->setHouseNo($response['house_number'])
            ->setStreet($response['street'])
            ->setTown($response['city'])
            ->setProvince($response['province'])
            ->setLatitude((float)$response['latitude'])
            ->setLongitude((float)$response['longitude']);

        return $address;
    }

    /**
     * @return mixed
     */
    protected function request()
    {
        $response = $this->getHttpClient()->request('GET', $this->getRequestUrl(), [
            'headers' => [
                'Tozken' => $this->getApiKey()
            ]
        ]);

        return json_decode($response->getBody(), true);
    }
}
