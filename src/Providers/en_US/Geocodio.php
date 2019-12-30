<?php

namespace nickurt\postcodeapi\Providers\en_US;

use nickurt\PostcodeApi\Entity\Address;

class Geocodio extends \nickurt\PostcodeApi\Providers\AbstractProvider
{
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
     * @param string $postCode
     * @param string $houseNumber
     */
    public function findByPostcodeAndHouseNumber($postCode, $houseNumber)
    {
        throw new \nickurt\PostcodeApi\Exception\NotSupportedException();
    }
}
