<?php

namespace nickurt\PostcodeApi\Providers\en_US;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Http\Guzzle6HttpClient as GraphHopperClient;
use nickurt\PostcodeApi\Providers\AbstractAdapter;

class GraphHopper extends AbstractAdapter
{
    /** @var string */
    protected $apiKey;

    /** @var GraphHopperClient */
    protected $client;

    /** @var string */
    protected $requestUrl = 'https://graphhopper.com/api/1/geocode';

    /**
     * @param GraphHopperClient $client
     */
    public function __construct(GraphHopperClient $client)
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
        $response = json_decode($this->client->get(sprintf('%s?q=%s&key=%s&limit=1', $this->getRequestUrl(), $postCode, $this->getApiKey()))->getBody(), true);

        if (count($response['hits']) < 1) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setTown($response['hits'][0]['city'] ?? $response['hits'][0]['name'] ?? null)
            ->setProvince($response['hits'][0]['state'])
            ->setLatitude($response['hits'][0]['point']['lat'])
            ->setLongitude($response['hits'][0]['point']['lng']);

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
     * @return Address
     */
    public function findByPostcodeAndHouseNumber($postCode, $houseNumber)
    {
        $response = json_decode($this->client->get(sprintf('%s?q=%s&key=%s&limit=1', $this->getRequestUrl(), $postCode . ',' . $houseNumber, $this->getApiKey()))->getBody(), true);

        if (count($response['hits']) < 1) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setHouseNo($response['hits'][0]['housenumber'] ?? null)
            ->setStreet($response['hits'][0]['street'] ?? null)
            ->setTown($response['hits'][0]['city'] ?? $response['hits'][0]['name'] ?? null)
            ->setProvince($response['hits'][0]['state'])
            ->setLatitude($response['hits'][0]['point']['lat'])
            ->setLongitude($response['hits'][0]['point']['lng']);

        return $address;
    }
}
