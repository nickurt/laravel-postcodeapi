<?php

namespace nickurt\PostcodeApi\Providers\nl_NL;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Http\Guzzle6HttpClient as PostcodesNLClient;
use nickurt\PostcodeApi\Providers\AbstractAdapter;

class PostcodesNL extends AbstractAdapter
{
    /** @var string */
    protected $apiKey;

    /** @var PostcodesNLClient */
    protected $client;

    /** @var string */
    protected $requestUrl = 'https://api.postcodes.nl/1.0/address';

    /**
     * @param PostcodesNLClient $client
     */
    public function __construct(PostcodesNLClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param $postCode
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
        $response = json_decode($this->client->get($this->getRequestUrl() . '?apikey=' . $this->getApiKey() . '&nlzip6=' . $postCode)->getBody(), true);

        if (isset($response['status']) && $response['status'] == 'error') {
            return new Address();
        }

        $address = new Address();
        $address
            ->setStreet($response['results'][0]['streetname'])
            ->setTown($response['results'][0]['city'])
            ->setMunicipality($response['results'][0]['municipality'])
            ->setProvince($response['results'][0]['province'])
            ->setLatitude($response['results'][0]['latitude'])
            ->setLongitude($response['results'][0]['longitude']);

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
        $response = json_decode($this->client->get($this->getRequestUrl() . '?apikey=' . $this->getApiKey() . '&nlzip6=' . $postCode . '&streetnumber=' . $houseNumber)->getBody(), true);

        if (isset($response['status']) && $response['status'] == 'error') {
            return new Address();
        }

        $address = new Address();
        $address
            ->setStreet($response['results'][0]['streetname'])
            ->setTown($response['results'][0]['city'])
            ->setHouseNo($houseNumber)
            ->setMunicipality($response['results'][0]['municipality'])
            ->setProvince($response['results'][0]['province'])
            ->setLatitude($response['results'][0]['latitude'])
            ->setLongitude($response['results'][0]['longitude']);

        return $address;
    }
}
