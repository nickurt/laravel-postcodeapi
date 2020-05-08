<?php

namespace nickurt\PostcodeApi\Providers\en_GB;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\Provider;

class PostcodesIO extends Provider
{
    protected function request()
    {
        $client = $this->getHttpClient();
        $response = $client->request('GET', $this->getRequestUrl());

        return json_decode($response->getBody(), true);
    }

    /**
     * @param string $postCode
     * @return Address
     */
    public function find($postCode)
    {
        $this->setRequestUrl(sprintf($this->getRequestUrl(), $postCode));

        $response = $this->request();

        if (!is_array($response['result'])) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setTown($response['result'][0]['region'])
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
