<?php

namespace nickurt\postcodeapi\Providers\nl_NL;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\AbstractAdapter;

class PostcodeNL extends AbstractAdapter
{
    /** @var string */
    protected $apiKey;

    /** @var string */
    protected $apiSecret;

    /** @var string */
    protected $requestUrl = 'https://api.postcode.nl/rest/addresses/%s/%s';

    /**
     * @param string $postCode
     * @return Address|void
     */
    public function find($postCode)
    {
        throw new \nickurt\PostcodeApi\Exceptions\NotSupportedException();
    }

    /**
     * @param string $postCode
     * @return Address|void
     */
    public function findByPostcode($postCode)
    {
        throw new \nickurt\PostcodeApi\Exceptions\NotSupportedException();
    }

    /**
     * @param $postCode
     * @param $houseNumber
     * @return Address
     */
    public function findByPostcodeAndHouseNumber($postCode, $houseNumber)
    {
        $response = $this->get('https://api.postcode.eu/nl/v1/addresses/postcode/' . $postCode . '/' . $houseNumber, [
            'auth' => [
                $this->getApiKey(), $this->getApiSecret()
            ]
        ]);

        $address = new Address();
        $address
            ->setStreet($response['street'])
            ->setTown($response['city'])
            ->setHouseNo((string)$response['houseNumber'])
            ->setMunicipality($response['municipality'])
            ->setProvince($response['province'])
            ->setLatitude($response['latitude'])
            ->setLongitude($response['longitude']);

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
     * @return string
     */
    public function getApiSecret()
    {
        return $this->apiSecret;
    }

    /**
     * @param string $apiSecret
     * @return $this
     */
    public function setApiSecret($apiSecret)
    {
        $this->apiSecret = $apiSecret;

        return $this;
    }
}
