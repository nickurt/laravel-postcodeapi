<?php

namespace nickurt\PostcodeApi\Providers\nl_BE;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Http\Guzzle6HttpClient as Pro6PPBEClient;
use nickurt\PostcodeApi\Providers\AbstractAdapter;

class Pro6PP_BE extends AbstractAdapter
{
    /** @var string */
    protected $apiKey;

    /** @var Pro6PPBEClient */
    protected $client;

    /** @var string */
    protected $requestUrl = 'https://api.pro6pp.nl/v1/autocomplete?auth_key=%s&be_fourpp=%s';

    /**
     * @param Pro6PPBEClient $client
     */
    public function __construct(Pro6PPBEClient $client)
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
        $response = json_decode($this->client->get(sprintf($this->getRequestUrl(), $this->getApiKey(), $postCode))->getBody(), true);

        if (isset($response['status']) && $response['status'] == 'error') {
            return new Address();
        }

        $address = new Address();
        $address
            ->setTown($response['results'][0]['city'])
            ->setMunicipality($response['results'][0]['municipality'])
            ->setProvince($response['results'][0]['province'])
            ->setLatitude($response['results'][0]['lat'])
            ->setLongitude($response['results'][0]['lng']);

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
