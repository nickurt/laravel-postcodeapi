<?php

namespace nickurt\postcodeapi\Providers\nl_NL;

use nickurt\PostcodeApi\Entity\Address;

class PostcodeNL extends \nickurt\PostcodeApi\Providers\AbstractProvider
{
    /** @var string */
    protected $requestUrl = 'https://api.postcode.nl/rest/addresses/%s/%s';

    /**
     * @param string $postCode
     * @return Address|void
     */
    public function find($postCode)
    {
        throw new \nickurt\PostcodeApi\Exception\NotSupportedException();
    }

    /**
     * @param string $postCode
     * @return Address|void
     */
    public function findByPostcode($postCode)
    {
        throw new \nickurt\PostcodeApi\Exception\NotSupportedException();
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
}
