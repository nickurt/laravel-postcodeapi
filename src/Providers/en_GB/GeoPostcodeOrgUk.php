<?php

namespace nickurt\PostcodeApi\Providers\en_GB;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Exceptions\NotSupportedException;
use nickurt\PostcodeApi\Http\Guzzle6HttpClient as GeoPostcodeOrgUkClient;
use nickurt\PostcodeApi\Providers\AbstractAdapter;

class GeoPostcodeOrgUk extends AbstractAdapter
{
    /** @var GeoPostcodeOrgUkClient */
    protected $client;

    /** @var string */
    protected $requestUrl = 'http://www.geopostcode.org.uk/api/%s.json';

    /**
     * @param GeoPostcodeOrgUkClient $client
     */
    public function __construct(GeoPostcodeOrgUkClient $client)
    {
        $this->client = $client;
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
     * @return Address
     */
    public function find($postCode)
    {
        if (!$response = json_decode($this->client->get(sprintf($this->getRequestUrl(), $postCode))->getBody(), true)) {
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
