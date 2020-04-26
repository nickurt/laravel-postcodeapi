<?php

namespace nickurt\PostcodeApi\Providers\fr_FR;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Http\Guzzle6HttpClient as AdresseDataGouvClient;
use nickurt\PostcodeApi\Providers\AbstractAdapter;

class AdresseDataGouv extends AbstractAdapter
{
    /** @var AdresseDataGouvClient */
    protected $client;

    /** @var string */
    protected $requestUrl = 'https://api-adresse.data.gouv.fr/search/?q=%s&postcode=%s&limit=1';

    /**
     * @param AdresseDataGouvClient $client
     */
    public function __construct(AdresseDataGouvClient $client)
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
        $response = json_decode($this->client->get(sprintf($this->getRequestUrl(), $postCode, ''))->getBody(), true);

        if (count($response['features']) < 1) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setTown($response['features'][0]['properties']['city'])
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
        $response = json_decode($this->client->get(sprintf($this->getRequestUrl(), urlencode($houseNumber), $postCode))->getBody(), true);

        if (count($response['features']) < 1) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setHouseNo($response['features'][0]['properties']['housenumber'])
            ->setStreet($response['features'][0]['properties']['street'])
            ->setTown($response['features'][0]['properties']['city'])
            ->setLatitude($response['features'][0]['geometry']['coordinates'][1])
            ->setLongitude($response['features'][0]['geometry']['coordinates'][0]);

        return $address;
    }
}
