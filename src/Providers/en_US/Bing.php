<?php

namespace nickurt\postcodeapi\Providers\en_US;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\AbstractAdapter;

class Bing extends AbstractAdapter
{
    /** @var string */
    protected $apiKey;

    /** @var string */
    protected $requestUrl = 'https://dev.virtualearth.net/REST/v1/Locations';

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

        $response = $this->get($this->getRequestUrl() . '?postalCode=' . $postCode . '&key=' . $this->getApiKey() . $options);

        if ($response['resourceSets'][0]['estimatedTotal'] < 1) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setTown($response['resourceSets'][0]['resources'][0]['address']['locality'])
            ->setMunicipality($response['resourceSets'][0]['resources'][0]['address']['adminDistrict2'] ?? null)
            ->setProvince($response['resourceSets'][0]['resources'][0]['address']['adminDistrict'] ?? null)
            ->setLatitude($response['resourceSets'][0]['resources'][0]['point']['coordinates'][0])
            ->setLongitude($response['resourceSets'][0]['resources'][0]['point']['coordinates'][1]);

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
