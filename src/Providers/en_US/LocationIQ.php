<?php

namespace nickurt\postcodeapi\Providers\en_US;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\Provider;

class LocationIQ extends Provider
{
    /**
     * @param string $postCode
     * @return Address
     */
    public function find($postCode)
    {
        $options = strlen($options = http_build_query($this->getOptions())) > 1 ? '&' . $options : '';

        $this->setRequestUrl($this->getRequestUrl() . '?q=' . $postCode . '&statecode=1&addressdetails=1&format=json&key=' . $this->getApiKey() . $options);

        $response = $this->request();

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

    protected function request()
    {
        try {
            $response = $this->getHttpClient()->request('GET', $this->getRequestUrl());
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return json_decode($e->getResponse()->getBody(), true);
        }

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
