<?php

namespace nickurt\postcodeapi\Providers\nl_NL;

use nickurt\PostcodeApi\Entity\Address;

class PostcodesNL extends \nickurt\PostcodeApi\Providers\AbstractProvider
{
    /** @var string */
    protected $requestUrl = 'https://api.postcodes.nl/1.0/address';

    /**
     * @param $postCode
     * @return Address
     */
    public function findByPostcode($postCode)
    {
        return $this->find($postCode);
    }

    /**
     * @param $postCode
     * @return Address
     */
    public function find($postCode)
    {
        $response = $this->get($this->getRequestUrl() . '?apikey=' . $this->getApiKey() . '&nlzip6=' . $postCode);

        if (isset($response['status']) && $response['status'] == 'error') {
            return new Address();
        }

        $address = new Address();
        $address
            ->setStreet($response['results'][0]['streetname'])
            ->setTown($response['results'][0]['city'])
            ->setMunicipality($response['results'][0]['municipality'])
            ->setProvince($response['results'][0]['province'])
            ->setLatitude($response['results'][0]['latitude'])
            ->setLongitude($response['results'][0]['longitude']);

        return $address;
    }

    /**
     * @param $postCode
     * @param $houseNumber
     * @return Address
     */
    public function findByPostcodeAndHouseNumber($postCode, $houseNumber)
    {
        $response = $this->get($this->getRequestUrl() . '?apikey=' . $this->getApiKey() . '&nlzip6=' . $postCode . '&streetnumber=' . $houseNumber);

        if (isset($response['status']) && $response['status'] == 'error') {
            return new Address();
        }

        $address = new Address();
        $address
            ->setStreet($response['results'][0]['streetname'])
            ->setTown($response['results'][0]['city'])
            ->setHouseNo($houseNumber)
            ->setMunicipality($response['results'][0]['municipality'])
            ->setProvince($response['results'][0]['province'])
            ->setLatitude($response['results'][0]['latitude'])
            ->setLongitude($response['results'][0]['longitude']);

        return $address;
    }
}
