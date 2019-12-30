<?php

namespace nickurt\postcodeapi\Providers\nl_NL;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\AbstractProvider;

class PostcodeData extends AbstractProvider
{
    /** @var string */
    protected $referer;

    /** @var string */
    protected $requestUrl = 'http://api.postcodedata.nl/v1/postcode/?postcode=%s&streetnumber=%s&ref=%s';

    /**
     * @param string $postCode
     */
    public function find($postCode)
    {
        throw new \nickurt\PostcodeApi\Exception\NotSupportedException();
    }

    /**
     * @param string $postCode
     */
    public function findByPostcode($postCode)
    {
        throw new \nickurt\PostcodeApi\Exception\NotSupportedException();
    }

    /**
     * @param string $postCode
     * @param string $houseNumber
     * @return Address
     */
    public function findByPostcodeAndHouseNumber($postCode, $houseNumber)
    {
        $response = $this->get(sprintf($this->getRequestUrl(), $postCode, $houseNumber, $this->getReferer()));

        if (isset($response['status']) && $response['status'] == 'error') {
            return new Address();
        }

        $address = new Address();
        $address
            ->setStreet($response['details'][0]['street'])
            ->setHouseNo($houseNumber)
            ->setTown($response['details'][0]['city'])
            ->setMunicipality($response['details'][0]['municipality'])
            ->setProvince($response['details'][0]['province'])
            ->setLatitude($response['details'][0]['lat'])
            ->setLongitude($response['details'][0]['lon']);

        return $address;
    }

    /**
     * @return string
     */
    public function getReferer()
    {
        return $this->referer ?? $this->referer = $_SERVER['HTTP_HOST'];
    }

    /**
     * @param $referer
     * @return $this
     */
    public function setReferer($referer)
    {
        $this->referer = $referer;

        return $this;
    }
}
