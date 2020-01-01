<?php

namespace nickurt\PostcodeApi\Providers\en_GB;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Http\Guzzle6HttpClient as GetAddressIOClient;
use nickurt\PostcodeApi\Providers\AbstractAdapter;

class GetAddressIO extends AbstractAdapter
{
    /** @var string */
    protected $apiKey;

    /** @var GetAddressIOClient */
    protected $client;

    /** @var string */
    protected $requestUrl = 'https://api.getaddress.io/find';

    /**
     * @param GetAddressIOClient $client
     */
    public function __construct(GetAddressIOClient $client)
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
        $response = json_decode($this->client->get($this->getRequestUrl() . '/' . $postCode . '?expand=true', [
            'headers' => [
                'api-key' => $this->getApiKey()
            ]
        ])->getBody(), true);

        if (isset($response['Message'])) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setLatitude($response['latitude'])
            ->setLongitude($response['longitude'])
            ->setTown($response['addresses'][0]['town_or_city'])
            ->setHouseNo($response['addresses'][0]['building_number'])
            ->setStreet($response['addresses'][0]['thoroughfare']);

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
        $response = json_decode($this->client->get($this->getRequestUrl() . '/' . $postCode . '/' . $houseNumber . '?expand=true', [
            'headers' => [
                'api-key' => $this->getApiKey()
            ]
        ])->getBody(), true);

        if (isset($response['Message'])) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setLatitude($response['latitude'])
            ->setLongitude($response['longitude'])
            ->setTown($response['addresses'][0]['town_or_city'])
            ->setHouseNo($response['addresses'][0]['building_number'])
            ->setStreet($response['addresses'][0]['thoroughfare']);

        return $address;
    }
}
