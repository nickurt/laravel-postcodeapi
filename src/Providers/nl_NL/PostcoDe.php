<?php

namespace nickurt\postcodeapi\Providers\nl_NL;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Exceptions\NotSupportedException;
use nickurt\PostcodeApi\Providers\AbstractProvider;

class PostcoDe extends AbstractProvider
{
    /** @var string */
    protected $requestUrl = 'https://api.postco.de/v1/postcode/%s/%s';

    /**
     * @param string $postCode
     */
    public function find($postCode)
    {
        throw new NotSupportedException();
    }

    /**
     * @param string $postCode
     */
    public function findByPostcode($postCode)
    {
        throw new NotSupportedException();
    }

    /**
     * @param string $postCode
     * @param string $houseNumber
     * @return Address
     */
    public function findByPostcodeAndHouseNumber($postCode, $houseNumber)
    {
        $postCode = strtoupper(preg_replace('/\s+/', '', $postCode));

        $response = $this->get(sprintf($this->getRequestUrl(), $postCode, $houseNumber));

        if (array_key_exists('error', $response)) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setHouseNo($houseNumber)
            ->setStreet($response['street'])
            ->setTown($response['city'])
            ->setMunicipality($response['municipality'])
            ->setProvince($response['province'])
            ->setLatitude($response['lat'])
            ->setLongitude($response['lon']);

        return $address;
    }
}
