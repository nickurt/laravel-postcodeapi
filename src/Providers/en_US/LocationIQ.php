<?php

namespace nickurt\postcodeapi\Providers\en_US;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\AbstractProvider;

class LocationIQ extends AbstractProvider
{
    /** @var string */
    protected $apiKey;

    /** @var string */
    protected $requestUrl = 'https://us1.locationiq.com/v1/search.php';

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
        $options = strlen($options = http_build_query($this->getOptions())) > 1 ? '&' . $options : '';

        $response = $this->get($this->getRequestUrl() . '?q=' . $postCode . '&statecode=1&addressdetails=1&format=json&key=' . $this->getApiKey() . $options);

        if (isset($response['error'])) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setTown($response[0]['address']['city'] ?? $response[0]['address']['town'])
            ->setMunicipality($response[0]['address']['county'] ?? $response[0]['address']['state'] ?? null)
            ->setProvince($response[0]['address']['state'] ?? null)
            ->setLatitude($response[0]['lat'])
            ->setLongitude($response[0]['lon']);

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
