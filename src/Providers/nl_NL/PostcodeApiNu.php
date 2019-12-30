<?php

namespace nickurt\postcodeapi\Providers\nl_NL;

use nickurt\PostcodeApi\Entity\Address;

class PostcodeApiNu extends \nickurt\PostcodeApi\Providers\AbstractProvider
{
    /** @var string */
    protected $requestUrl = 'https://api.postcodeapi.nu/v3/lookup';

    /**
     * @param string $postCode
     */
    public function find($postCode)
    {
        throw new \nickurt\PostcodeApi\Exception\NotSupportedException();
    }

    /**
     * @param string $postCode
     */
    public function findByPostcode($postCode)
    {
        throw new \nickurt\PostcodeApi\Exception\NotSupportedException();
    }

    /**
     * @param string $postCode
     * @param string $houseNumber
     * @return Address
     */
    public function findByPostcodeAndHouseNumber($postCode, $houseNumber)
    {
        $postCode = strtoupper(preg_replace('/\s+/', '', $postCode));

        $response = $this->get($this->getRequestUrl() . '/' . $postCode . '/' . $houseNumber, [
            'headers' => [
                'X-Api-Key' => $this->getApiKey()
            ]
        ]);

        if (isset($response['title'])) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setHouseNo((string)$response['number'])
            ->setStreet($response['street'])
            ->setTown($response['city'])
            ->setMunicipality($response['municipality'])
            ->setProvince($response['province']);

        return $address;
    }
}
