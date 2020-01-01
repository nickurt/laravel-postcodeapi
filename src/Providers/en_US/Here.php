<?php

namespace nickurt\PostcodeApi\Providers\en_US;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Http\Guzzle6HttpClient as HereClient;
use nickurt\PostcodeApi\Providers\AbstractAdapter;

class Here extends AbstractAdapter
{
    /** @var string */
    protected $apiKey;

    /** @var string */
    protected $apiSecret;

    /** @var HereClient */
    protected $client;

    /** @var string */
    protected $requestUrl = 'https://geocoder.api.here.com/6.2/geocode.json';

    /**
     * @param HereClient $client
     */
    public function __construct(HereClient $client)
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
        $options = strlen($options = http_build_query($this->getOptions())) > 1 ? '&' . $options : '';

        $response = json_decode($this->client->get($this->getRequestUrl() . '?postalCode=' . $postCode . '&app_id=' . $this->getApiKey() . '&app_code=' . $this->getApiSecret() . '&gen=9' . $options)->getBody(), true);

        if (count($response['Response']['View']) < 1) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setStreet($response['Response']['View'][0]['Result'][0]['Location']['Address']['Street'] ?? null)
            ->setHouseNo($response['Response']['View'][0]['Result'][0]['Location']['Address']['HouseNumber'] ?? null)
            ->setTown($response['Response']['View'][0]['Result'][0]['Location']['Address']['City'])
            ->setMunicipality($response['Response']['View'][0]['Result'][0]['Location']['Address']['County'] ?? null)
            ->setProvince($response['Response']['View'][0]['Result'][0]['Location']['Address']['State'])
            ->setLatitude($response['Response']['View'][0]['Result'][0]['Location']['DisplayPosition']['Latitude'])
            ->setLongitude($response['Response']['View'][0]['Result'][0]['Location']['DisplayPosition']['Longitude']);

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
     * @return string
     */
    public function getApiSecret()
    {
        return $this->apiSecret;
    }

    /**
     * @param string $apiSecret
     * @return $this
     */
    public function setApiSecret($apiSecret)
    {
        $this->apiSecret = $apiSecret;

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
