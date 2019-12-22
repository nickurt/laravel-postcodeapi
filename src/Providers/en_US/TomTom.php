<?php

namespace nickurt\postcodeapi\Providers\en_US;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Exception\NotSupportedException;
use nickurt\PostcodeApi\Providers\Provider;

class TomTom extends Provider
{
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

        $this->setRequestUrl(sprintf($this->getRequestUrl(), $postCode) . '?key=' . $this->getApiKey() . $options);

        $response = $this->request();

        if ($response['summary']['totalResults'] < 1) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setTown($response['results'][0]['address']['municipalitySubdivision'])
            ->setMunicipality($response['results'][0]['address']['municipality'])
            ->setProvince($response['results'][0]['address']['countrySubdivision'])
            ->setLatitude($response['results'][0]['position']['lat'])
            ->setLongitude($response['results'][0]['position']['lon']);

        return $address;
    }

    protected function request()
    {
        $response = $this->getHttpClient()->request('GET', $this->getRequestUrl());

        return json_decode($response->getBody(), true);
    }

    /**
     * @param string $postCode
     * @param string $houseNumber
     */
    public function findByPostcodeAndHouseNumber($postCode, $houseNumber)
    {
        throw new NotSupportedException();
    }
}
