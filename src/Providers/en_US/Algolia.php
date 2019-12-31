<?php

namespace nickurt\PostcodeApi\Providers\en_US;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\AbstractAdapter;

class Algolia extends AbstractAdapter
{
    /** @var string */
    protected $apiKey;

    /** @var string */
    protected $apiSecret;

    /** @var string */
    protected $requestUrl = 'https://places-dsn.algolia.net/1/places/query';

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
        $this->setOptions(array_merge($this->getOptions(), [
            'query' => $postCode,
            'hitsPerPage' => 1,
        ]));

        $response = $this->post($this->getRequestUrl(), [
            'headers' => $this->getHeaders(),
            'body' => json_encode($this->getOptions())
        ]);

        if ($response['nbHits'] < 1) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setTown($response['hits'][0]['locale_names']['default'][0])
            ->setMunicipality($response['hits'][0]['county']['default'][0] ?? $response['hits'][0]['city']['default'][0] ?? null)
            ->setProvince($response['hits'][0]['administrative'][0])
            ->setLatitude($response['hits'][0]['_geoloc']['lat'])
            ->setLongitude($response['hits'][0]['_geoloc']['lng']);

        return $address;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        if (empty($this->getApiKey()) || empty($this->getApiSecret())) {
            return [];
        }

        return [
            'X-Algolia-Application-Id' => $this->getApiSecret(),
            'X-Algolia-API-Key' => $this->getApiKey(),
        ];
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
     * @return Address
     */
    public function findByPostcodeAndHouseNumber($postCode, $houseNumber)
    {
        $this->setOptions(array_merge($this->getOptions(), [
            'query' => $postCode . '+' . $houseNumber,
            'hitsPerPage' => 1,
        ]));

        $response = $this->post($this->getRequestUrl(), [
            'headers' => $this->getHeaders(),
            'body' => json_encode($this->getOptions())
        ]);

        if ($response['nbHits'] < 1) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setTown($response['hits'][0]['city']['default'][0])
            ->setMunicipality($response['hits'][0]['county']['default'][0] ?? $response['hits'][0]['city']['default'][0] ?? null)
            ->setProvince($response['hits'][0]['administrative'][0])
            ->setLatitude($response['hits'][0]['_geoloc']['lat'])
            ->setLongitude($response['hits'][0]['_geoloc']['lng']);

        return $address;
    }
}
