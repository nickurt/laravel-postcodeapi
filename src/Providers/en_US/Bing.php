<?php

namespace nickurt\PostcodeApi\Providers\en_US;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\Provider;

class Bing extends Provider
{
    /**
     * @param string $postCode
     * @return Address
     */
    public function find($postCode)
    {
        $options = strlen($options = http_build_query($this->getOptions())) > 1 ? '&' . $options : '';

        $this->setRequestUrl($this->getRequestUrl() . '?postalCode=' . $postCode . '&key=' . $this->getApiKey() . $options);

        $response = $this->request();

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

    protected function request()
    {
        $response = $this->getHttpClient()->request('GET', $this->getRequestUrl());

        return json_decode($response->getBody(), true);
    }

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
     * @param string $houseNumber
     */
    public function findByPostcodeAndHouseNumber($postCode, $houseNumber)
    {
        throw new \nickurt\PostcodeApi\Exception\NotSupportedException();
    }
}
