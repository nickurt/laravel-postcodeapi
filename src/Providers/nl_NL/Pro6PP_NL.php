<?php

namespace nickurt\PostcodeApi\Providers\nl_NL;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\Provider;

class Pro6PP_NL extends Provider
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
        $this->setRequestUrl(sprintf($this->getRequestUrl(), $this->getApiKey(), $postCode));

        $response = $this->request();

        if (isset($response['status']) && $response['status'] == 'error') {
            return new Address();
        }

        return $this->toAddress($response);
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
     * @return Address
     */
    public function findByPostcodeAndHouseNumber($postCode, $houseNumber)
    {
        $this->setRequestUrl(sprintf($this->getRequestUrl(), $this->getApiKey(), $postCode) . '&streetnumber=' . $houseNumber);

        $response = $this->request();

        if (isset($response['status']) && $response['status'] == 'error') {
            return new Address();
        }

        return $this->toAddress($response)
            ->setHouseNo($houseNumber);
    }

    /**
     * @param  array  $response
     * @return Address
     */
    protected function toAddress(array $response)
    {
        $address = new Address();
        $address
            ->setStreet($response['results'][0]['street'])
            ->setTown($response['results'][0]['city'])
            ->setMunicipality($response['results'][0]['municipality'])
            ->setProvince($response['results'][0]['province']);

        if (! empty($latitude = $response['results'][0]['lat']) && ! empty($longitude = $response['results'][0]['lng'])) {
            $address->setLatitude($latitude)
                ->setLongitude($longitude);
        }

        return $address;
    }
}
