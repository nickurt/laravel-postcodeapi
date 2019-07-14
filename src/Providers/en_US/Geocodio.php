<?php

namespace nickurt\postcodeapi\Providers\en_US;

use \nickurt\PostcodeApi\Providers\Provider;
use \nickurt\PostcodeApi\Entity\Address;

class Geocodio extends Provider
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
            ->setMunicipality($response['results'][0]['address_components']['state'])
            ->setStreet($response['results'][0]['address_components']['formatted_street'])
            ->setTown($response['results'][0]['address_components']['city'])
            ->setLatitude($response['results'][0]['location']['lat'])
            ->setLongitude($response['results'][0]['location']['lng']);

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
