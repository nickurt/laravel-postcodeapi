<?php

namespace nickurt\PostcodeApi\Providers\en_GB;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\Provider;

class IdealPostcodes extends Provider
{
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
    public function find($postCode)
    {
        $this->setRequestUrl(sprintf($this->getRequestUrl(), $postCode, $this->getApiKey()));

        $response = $this->request();

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
