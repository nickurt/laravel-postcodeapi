<?php

namespace nickurt\PostcodeApi\Providers\en_US;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Http\Guzzle6HttpClient as OpenCageClient;
use nickurt\PostcodeApi\Providers\AbstractAdapter;

class OpenCage extends AbstractAdapter
{
    /** @var string */
    protected $apiKey;

    /** @var OpenCageClient */
    protected $client;

    /** @var string */
    protected $requestUrl = 'https://api.opencagedata.com/geocode/v1/json';

    /**
     * @param OpenCageClient $client
     */
    public function __construct(OpenCageClient $client)
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

        $response = json_decode($this->client->get($this->getRequestUrl() . '?q=' . $postCode . '&key=' . $this->getApiKey() . $options)->getBody(), true);

        if ($response['total_results'] < 1) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setTown($response['results'][0]['components']['city'] ?? $response['results'][0]['components']['suburb'])
            ->setMunicipality($response['results'][0]['components']['country'])
            ->setProvince($response['results'][0]['components']['state'])
            ->setLatitude($response['results'][0]['geometry']['lat'])
            ->setLongitude($response['results'][0]['geometry']['lng']);

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
