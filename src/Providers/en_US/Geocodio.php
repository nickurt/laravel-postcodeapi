<?php

namespace nickurt\PostcodeApi\Providers\en_US;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Http\Guzzle6HttpClient as GeocodioClient;
use nickurt\PostcodeApi\Providers\AbstractAdapter;

class Geocodio extends AbstractAdapter
{
    /** @var string */
    protected $apiKey;

    /** @var GeocodioClient */
    protected $client;

    /** @var string */
    protected $requestUrl = 'https://api.geocod.io/v1.3/geocode/?q=%s&api_key=%s';

    /**
     * @param GeocodioClient $client
     */
    public function __construct(GeocodioClient $client)
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
        $response = json_decode($this->client->get(sprintf($this->getRequestUrl(), $postCode, $this->getApiKey()))->getBody(), true);

        if (count($response['results']) < 1) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setMunicipality($response['results'][0]['address_components']['state'])
            ->setStreet($response['results'][0]['address_components']['formatted_street'] ?? null)
            ->setTown($response['results'][0]['address_components']['city'])
            ->setLatitude($response['results'][0]['location']['lat'])
            ->setLongitude($response['results'][0]['location']['lng']);

        return $address;
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param $apiKey
     * @return $this
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;

        return $this;
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
