<?php

namespace nickurt\postcodeapi\Providers\en_GB;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\AbstractProvider;

class PostcodesIO extends AbstractProvider
{
    /** @var string */
    protected $requestUrl = 'https://api.postcodes.io/postcodes?q=%s';

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
        $response = $this->get(sprintf($this->getRequestUrl(), $postCode));

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
     * @param string $houseNumber
     */
    public function findByPostcodeAndHouseNumber($postCode, $houseNumber)
    {
        throw new \nickurt\PostcodeApi\Exceptions\NotSupportedException();
    }
}
