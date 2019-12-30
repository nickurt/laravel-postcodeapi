<?php

namespace nickurt\postcodeapi\Providers\en_AU;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Exception\NotSupportedException;
use nickurt\PostcodeApi\Providers\AbstractProvider;

class PostcodeApiComAu extends AbstractProvider
{
    /** @var string */
    protected $requestUrl = 'http://v0.postcodeapi.com.au/suburbs/%s.json';

    /**
     * @param string $postCode
     * @return mixed
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
        $response = $this->get(sprintf($this->getRequestUrl(), $postCode));

        if (count($response) < 1) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setTown($response[0]['name'])
            ->setMunicipality($response[0]['state']['name'])
            ->setLatitude($response[0]['latitude'])
            ->setLongitude($response[0]['longitude']);

        return $address;
    }

    /**
     * @param string $postCode
     * @param string $houseNumber
     */
    public function findByPostcodeAndHouseNumber($postCode, $houseNumber)
    {
        throw new NotSupportedException();
    }
}
