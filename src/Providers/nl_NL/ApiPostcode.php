<?php

namespace nickurt\postcodeapi\Providers\nl_NL;

use nickurt\PostcodeApi\Entity\Address;

class ApiPostcode extends \nickurt\PostcodeApi\Providers\AbstractProvider
{
    /** @var string */
    protected $requestUrl = 'http://json.api-postcode.nl';

    /**
     * @param string $postCode
     * @return Address
     */
    public function findByPostcode($postCode)
    {
        return $this->find($postCode);
    }

    /**
     * @param $postCode
     * @return Address
     */
    public function find($postCode)
    {
        $postCode = strtoupper(preg_replace('/\s+/', '', $postCode));

        $response = $this->get($this->getRequestUrl() . '?postcode=' . $postCode, [
            'headers' => [
                'Token' => $this->getApiKey()
            ]
        ]);

        if (isset($response['error'])) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setStreet($response['street'])
            ->setTown($response['city'])
            ->setProvince($response['province'])
            ->setLatitude($response['latitude'])
            ->setLongitude($response['longitude']);

        return $address;
    }

    /**
     * @param $postCode
     * @param $houseNumber
     * @return Address
     */
    public function findByPostcodeAndHouseNumber($postCode, $houseNumber)
    {
        $postCode = strtoupper(preg_replace('/\s+/', '', $postCode));

        $response = $this->get($this->getRequestUrl() . '?postcode=' . $postCode . '&number=' . $houseNumber, [
            'headers' => [
                'Token' => $this->getApiKey()
            ]
        ]);

        if (isset($response['error'])) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setHouseNo($response['house_number'])
            ->setStreet($response['street'])
            ->setTown($response['city'])
            ->setProvince($response['province'])
            ->setLatitude($response['latitude'])
            ->setLongitude($response['longitude']);

        return $address;
    }
}
