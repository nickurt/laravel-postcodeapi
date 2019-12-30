<?php

namespace nickurt\postcodeapi\Providers\en_GB;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Exception\NotSupportedException;

class GeoPostcodeOrgUk extends \nickurt\PostcodeApi\Providers\AbstractProvider
{
    /** @var string */
    protected $requestUrl = 'http://www.geopostcode.org.uk/api/%s.json';

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
        if (!$response = $this->get(sprintf($this->getRequestUrl(), $postCode))) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setLatitude($response['wgs84']['lat'])
            ->setLongitude($response['wgs84']['lon']);

        return $address;
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
