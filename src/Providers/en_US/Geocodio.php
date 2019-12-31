<?php

namespace nickurt\PostcodeApi\Providers\en_US;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\AbstractAdapter;

class Geocodio extends AbstractAdapter
{
    /** @var string */
    protected $apiKey;

    /** @var string */
    protected $requestUrl = 'https://api.geocod.io/v1.3/geocode/?q=%s&api_key=%s';

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
        $response = $this->get(sprintf($this->getRequestUrl(), $postCode, $this->getApiKey()));

        if (count($response['results']) < 1) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setMunicipality($response['results'][0]['address_components']['state'])
            ->setStreet($response['results'][0]['address_components']['formatted_street'] ?? null)
            ->setTown($response['results'][0]['address_components']['city'])
            ->setLatitude($response['results'][0]['location']['lat'])
            ->setLongitude($response['results'][0]['location']['lng']);

        return $address;
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param $apiKey
     * @return $this
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * @param string $postCode
     * @param string $houseNumber
     */
    public function findByPostcodeAndHouseNumber($postCode, $houseNumber)
    {
        throw new \nickurt\PostcodeApi\Exceptions\NotSupportedException();
    }
}
