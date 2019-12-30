<?php

namespace nickurt\postcodeapi\Providers\en_GB;

use nickurt\PostcodeApi\Entity\Address;

class IdealPostcodes extends \nickurt\PostcodeApi\Providers\AbstractProvider
{
    /** @var string */
    protected $apiKey;

    /** @var string */
    protected $requestUrl = 'https://api.ideal-postcodes.co.uk/v1/postcodes/%s?api_key=%s';

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

        if (isset($response['message']) && $response['message'] != "Success") {
            return new Address();
        }

        $address = new Address();
        $address
            ->setTown($response['result'][0]['post_town'])
            ->setStreet($response['result'][0]['line_1'])
            ->setLatitude($response['result'][0]['latitude'])
            ->setLongitude($response['result'][0]['longitude']);

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
        throw new \nickurt\PostcodeApi\Exception\NotSupportedException();
    }
}
