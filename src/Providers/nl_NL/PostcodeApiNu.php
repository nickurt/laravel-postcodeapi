<?php

namespace nickurt\PostcodeApi\Providers\nl_NL;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Http\Guzzle6HttpClient as PostcodeApiNuClient;
use nickurt\PostcodeApi\Providers\AbstractAdapter;

class PostcodeApiNu extends AbstractAdapter
{
    /** @var string */
    protected $apiKey;

    /** @var PostcodeApiNuClient */
    protected $client;

    /** @var string */
    protected $requestUrl = 'https://api.postcodeapi.nu/v3/lookup';

    /**
     * @param PostcodeApiNuClient $client
     */
    public function __construct(PostcodeApiNuClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $postCode
     */
    public function find($postCode)
    {
        throw new \nickurt\PostcodeApi\Exceptions\NotSupportedException();
    }

    /**
     * @param string $postCode
     */
    public function findByPostcode($postCode)
    {
        throw new \nickurt\PostcodeApi\Exceptions\NotSupportedException();
    }

    /**
     * @param string $postCode
     * @param string $houseNumber
     * @return Address
     */
    public function findByPostcodeAndHouseNumber($postCode, $houseNumber)
    {
        $postCode = strtoupper(preg_replace('/\s+/', '', $postCode));

        $response = json_decode($this->client->get($this->getRequestUrl() . '/' . $postCode . '/' . $houseNumber, [
            'headers' => [
                'X-Api-Key' => $this->getApiKey()
            ]
        ])->getBody(), true);

        if (isset($response['title'])) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setHouseNo((string)$response['number'])
            ->setStreet($response['street'])
            ->setTown($response['city'])
            ->setMunicipality($response['municipality'])
            ->setProvince($response['province']);

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
}
