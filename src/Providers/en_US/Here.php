<?php

namespace nickurt\postcodeapi\Providers\en_US;

use nickurt\PostcodeApi\Entity\Address;

class Here extends \nickurt\PostcodeApi\Providers\AbstractProvider
{
    /** @var string */
    protected $requestUrl = 'https://geocoder.api.here.com/6.2/geocode.json';

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

        $response = $this->get($this->getRequestUrl() . '?postalCode=' . $postCode . '&app_id=' . $this->getApiKey() . '&app_code=' . $this->getApiSecret() . '&gen=9' . $options);

        if (count($response['Response']['View']) < 1) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setStreet($response['Response']['View'][0]['Result'][0]['Location']['Address']['Street'] ?? null)
            ->setHouseNo($response['Response']['View'][0]['Result'][0]['Location']['Address']['HouseNumber'] ?? null)
            ->setTown($response['Response']['View'][0]['Result'][0]['Location']['Address']['City'])
            ->setMunicipality($response['Response']['View'][0]['Result'][0]['Location']['Address']['County'] ?? null)
            ->setProvince($response['Response']['View'][0]['Result'][0]['Location']['Address']['State'])
            ->setLatitude($response['Response']['View'][0]['Result'][0]['Location']['DisplayPosition']['Latitude'])
            ->setLongitude($response['Response']['View'][0]['Result'][0]['Location']['DisplayPosition']['Longitude']);

        return $address;
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
