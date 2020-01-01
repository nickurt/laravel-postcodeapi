<?php

namespace nickurt\PostcodeApi\Providers\en_US;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Http\Guzzle6HttpClient as PhotonClient;
use nickurt\PostcodeApi\Providers\AbstractAdapter;

class Photon extends AbstractAdapter
{
    /** @var PhotonClient */
    protected $client;

    /** @var string */
    protected $requestUrl = 'https://photon.komoot.de';

    /**
     * @param PhotonClient $client
     */
    public function __construct(PhotonClient $client)
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

        $response = json_decode($this->client->get($this->getRequestUrl() . '/api/?q=' . $postCode . '&limit=1' . $options)->getBody(), true);

        if (count($response['features']) < 1) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setTown($response['features'][0]['properties']['city'] ?? $response['features'][0]['properties']['name'])
            ->setProvince($response['features'][0]['properties']['state'] ?? null)
            ->setLatitude($response['features'][0]['geometry']['coordinates'][1])
            ->setLongitude($response['features'][0]['geometry']['coordinates'][0]);

        return $address;
    }

    /**
     * @param string $postCode
     * @param string $houseNumber
     * @return Address
     */
    public function findByPostcodeAndHouseNumber($postCode, $houseNumber)
    {
        $options = strlen($options = http_build_query($this->getOptions())) > 1 ? '&' . $options : '';

        $response = json_decode($this->client->get($this->getRequestUrl() . '/api/?q=' . $postCode . ',' . $houseNumber . '&limit=1' . $options)->getBody(), true);

        if (count($response['features']) < 1) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setHouseNo($response['features'][0]['properties']['housenumber'] ?? null)
            ->setStreet($response['features'][0]['properties']['street'] ?? null)
            ->setTown($response['features'][0]['properties']['city'])
            ->setProvince($response['features'][0]['properties']['state'] ?? null)
            ->setLatitude($response['features'][0]['geometry']['coordinates'][1])
            ->setLongitude($response['features'][0]['geometry']['coordinates'][0]);

        return $address;
    }
}
