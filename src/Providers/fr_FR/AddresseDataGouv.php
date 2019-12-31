<?php

namespace nickurt\postcodeapi\Providers\fr_FR;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\AbstractAdapter;

class AddresseDataGouv extends AbstractAdapter
{
    /** @var string */
    protected $requestUrl = 'https://api-adresse.data.gouv.fr/search/?q=%s&postcode=%s&limit=1';

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
        $response = $this->get(sprintf($this->getRequestUrl(), $postCode, ''));

        if (count($response['features']) < 1) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setTown($response['features'][0]['properties']['city'])
            ->setLatitude($response['features'][0]['geometry']['coordinates'][1])
            ->setLongitude($response['features'][0]['geometry']['coordinates'][0]);

        return $address;
    }

    /**
     * @param string $postCode
     * @param string $houseNumber
     * @return Address
     */
    public function findByPostcodeAndHouseNumber($postCode, $houseNumber)
    {
        $response = $this->get(sprintf($this->getRequestUrl(), urlencode($houseNumber), $postCode));

        if (count($response['features']) < 1) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setHouseNo($response['features'][0]['properties']['housenumber'])
            ->setStreet($response['features'][0]['properties']['street'])
            ->setTown($response['features'][0]['properties']['city'])
            ->setLatitude($response['features'][0]['geometry']['coordinates'][1])
            ->setLongitude($response['features'][0]['geometry']['coordinates'][0]);

        return $address;
    }
}
