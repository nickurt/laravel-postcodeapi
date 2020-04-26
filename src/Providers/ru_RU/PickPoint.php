<?php

namespace nickurt\PostcodeApi\Providers\ru_RU;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Exceptions\NotSupportedException;
use nickurt\PostcodeApi\Http\Guzzle6HttpClient as PickPointClient;
use nickurt\PostcodeApi\Providers\AbstractAdapter;

class PickPoint extends AbstractAdapter
{
    /** @var string */
    protected $apiKey;

    /** @var PickPointClient */
    protected $client;

    /** @var string */
    protected $requestUrl = 'https://api.pickpoint.io/v1/forward';

    /**
     * @param PickPointClient $client
     */
    public function __construct(PickPointClient $client)
    {
        $this->client = $client;
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
     * @return mixed
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

        $response = json_decode($this->client->get($this->getRequestUrl() . '?q=' . $postCode . '&format=json&addressdetails=1&limit=1&key=' . $this->getApiKey() . $options)->getBody(), true);

        if (count($response) < 1) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setTown($response[0]['address']['city'] ?? $response[0]['address']['suburb'])
            ->setProvince($response[0]['address']['state'] ?? null)
            ->setLatitude($response[0]['lat'])
            ->setLongitude($response[0]['lon']);

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
