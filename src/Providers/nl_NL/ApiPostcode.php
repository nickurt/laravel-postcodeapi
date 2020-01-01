<?php

namespace nickurt\PostcodeApi\Providers\nl_NL;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Http\Guzzle6HttpClient as ApiPostcodeClient;
use nickurt\PostcodeApi\Providers\AbstractAdapter;

class ApiPostcode extends AbstractAdapter
{
    /** @var string */
    protected $apiKey;

    /** @var ApiPostcodeClient */
    protected $client;

    /** @var string */
    protected $requestUrl = 'http://json.api-postcode.nl';

    /**
     * @param ApiPostcodeClient $client
     */
    public function __construct(ApiPostcodeClient $client)
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
     * @param $postCode
     * @return Address
     */
    public function find($postCode)
    {
        $postCode = strtoupper(preg_replace('/\s+/', '', $postCode));

        $response = json_decode($this->client->get($this->getRequestUrl() . '?postcode=' . $postCode, [
            'headers' => [
                'Token' => $this->getApiKey()
            ]
        ])->getBody(), true);

        if (isset($response['error'])) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setStreet($response['street'])
            ->setTown($response['city'])
            ->setProvince($response['province'])
            ->setLatitude($response['latitude'])
            ->setLongitude($response['longitude']);

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
     * @param $postCode
     * @param $houseNumber
     * @return Address
     */
    public function findByPostcodeAndHouseNumber($postCode, $houseNumber)
    {
        $postCode = strtoupper(preg_replace('/\s+/', '', $postCode));

        $response = json_decode($this->client->get($this->getRequestUrl() . '?postcode=' . $postCode . '&number=' . $houseNumber, [
            'headers' => [
                'Token' => $this->getApiKey()
            ]
        ])->getBody(), true);

        if (isset($response['error'])) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setHouseNo($response['house_number'])
            ->setStreet($response['street'])
            ->setTown($response['city'])
            ->setProvince($response['province'])
            ->setLatitude($response['latitude'])
            ->setLongitude($response['longitude']);

        return $address;
    }
}
