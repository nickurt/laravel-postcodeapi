<?php

namespace nickurt\PostcodeApi\Providers\en_GB;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Http\Guzzle6HttpClient as IdealPostcodesClient;
use nickurt\PostcodeApi\Providers\AbstractAdapter;

class IdealPostcodes extends AbstractAdapter
{
    /** @var string */
    protected $apiKey;

    /** @var IdealPostcodesClient */
    protected $client;

    /** @var string */
    protected $requestUrl = 'https://api.ideal-postcodes.co.uk/v1/postcodes/%s?api_key=%s';

    /**
     * @param IdealPostcodesClient $client
     */
    public function __construct(IdealPostcodesClient $client)
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

        if (isset($response['message']) && $response['message'] != "Success") {
            return new Address();
        }

        $address = new Address();
        $address
            ->setTown($response['result'][0]['post_town'])
            ->setStreet($response['result'][0]['line_1'])
            ->setLatitude($response['result'][0]['latitude'])
            ->setLongitude($response['result'][0]['longitude']);

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
