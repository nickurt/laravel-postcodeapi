<?php

namespace nickurt\postcodeapi\Providers\en_GB;

use \nickurt\PostcodeApi\Providers\Provider;
use \nickurt\PostcodeApi\Entity\Address;

class GetAddressIO extends Provider
{
    /**
     * @param $postCode
     * @return Address
     */
    public function find($postCode)
    {
        $this->setRequestUrl(sprintf($this->getRequestUrl(), $postCode, $this->getApiKey()));
        $response = $this->request();

        $address = new Address();
        $address
            ->setLatitude($response['latitude'])
            ->setLongitude($response['longitude'])
            ->setStreet($response['addresses'][0]);

        return $address;
    }

    /**
     * @return mixed
     */
    protected function request()
    {
        $response = $this->getHttpClient()->request('GET', $this->getRequestUrl());

        return json_decode($response->getBody(), true);
    }

    public function findByPostcode($postCode)
    {

    }

    public function findByPostcodeAndHouseNumber($postCode, $houseNumber)
    {

    }
}
